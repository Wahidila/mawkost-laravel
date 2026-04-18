<?php

namespace App\Services;

use App\Models\KostImage;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class WatermarkService
{
    /**
     * Check if watermark feature is enabled and configured.
     */
    public function isEnabled(): bool
    {
        return Setting::get('watermark_enabled', '0') === '1'
            && !empty(Setting::get('watermark_image'));
    }

    /**
     * Apply watermark to a single image stored on the public disk.
     *
     * @param string $storagePath  Path relative to the public disk (e.g. "kosts/abc123.webp")
     * @return bool
     */
    public function apply(string $storagePath): bool
    {
        if (!$this->isEnabled()) {
            return false;
        }

        $watermarkRelPath = Setting::get('watermark_image');
        if (!$watermarkRelPath) {
            return false;
        }

        // Resolve the watermark image absolute path
        // watermark_image is stored as "storage/watermarks/file.png" (same convention as kost images)
        $watermarkDiskPath = str_replace('storage/', '', $watermarkRelPath);
        $watermarkAbsPath = Storage::disk('public')->path($watermarkDiskPath);

        if (!file_exists($watermarkAbsPath)) {
            return false;
        }

        // Resolve the target image absolute path
        $imageAbsPath = Storage::disk('public')->path($storagePath);
        if (!file_exists($imageAbsPath)) {
            return false;
        }

        $opacity = (int) Setting::get('watermark_opacity', '50');
        $sizePercent = (int) Setting::get('watermark_size', '30');

        // Clamp values
        $opacity = max(0, min(100, $opacity));
        $sizePercent = max(10, min(80, $sizePercent));

        try {
            $image = Image::make($imageAbsPath);
            $watermark = Image::make($watermarkAbsPath);

            // Resize watermark proportionally based on the target image width
            $watermarkWidth = (int) ($image->width() * $sizePercent / 100);
            $watermark->resize($watermarkWidth, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // Set opacity (Intervention Image v2 uses opacity method)
            $watermark->opacity($opacity);

            // Insert watermark at center
            $image->insert($watermark, 'center');

            // Save the watermarked image (overwrite original)
            $image->save($imageAbsPath);

            // Free memory
            $image->destroy();
            $watermark->destroy();

            return true;
        } catch (\Exception $e) {
            \Log::error('Watermark apply failed: ' . $e->getMessage(), [
                'image' => $storagePath,
                'watermark' => $watermarkRelPath,
            ]);
            return false;
        }
    }

    /**
     * Apply watermark to all existing kost images.
     * Backs up originals to kosts_original/ before applying.
     *
     * @return array{processed: int, failed: int, skipped: int}
     */
    public function applyToAll(): array
    {
        $result = ['processed' => 0, 'failed' => 0, 'skipped' => 0];

        if (!$this->isEnabled()) {
            return $result;
        }

        // Get all kost images that are stored in the storage (not seed assets)
        $images = KostImage::where('image_path', 'like', 'storage/kosts/%')->get();

        foreach ($images as $img) {
            $diskPath = str_replace('storage/', '', $img->image_path);

            if (!Storage::disk('public')->exists($diskPath)) {
                $result['skipped']++;
                continue;
            }

            // Backup original before watermarking (only first time)
            $backupPath = str_replace('kosts/', 'kosts_original/', $diskPath);
            if (!Storage::disk('public')->exists($backupPath)) {
                Storage::disk('public')->copy($diskPath, $backupPath);
            }

            // Restore from backup so watermark is applied to clean original
            Storage::disk('public')->copy($backupPath, $diskPath);

            // Apply watermark
            if ($this->apply($diskPath)) {
                $result['processed']++;
            } else {
                $result['failed']++;
            }
        }

        return $result;
    }
}
