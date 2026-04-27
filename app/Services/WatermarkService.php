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

    public function apply(string $storagePath): bool
    {
        if (!$this->isEnabled()) {
            return false;
        }

        $watermarkRelPath = Setting::get('watermark_image');
        if (!$watermarkRelPath) {
            return false;
        }

        $watermarkDiskPath = str_replace('storage/', '', $watermarkRelPath);
        $watermarkAbsPath = Storage::disk('public')->path($watermarkDiskPath);

        if (!file_exists($watermarkAbsPath)) {
            return false;
        }

        $imageAbsPath = Storage::disk('public')->path($storagePath);
        if (!file_exists($imageAbsPath)) {
            return false;
        }

        $this->backupOriginal($storagePath);

        $opacity = (int) Setting::get('watermark_opacity', '50');
        $sizePercent = (int) Setting::get('watermark_size', '30');

        $opacity = max(0, min(100, $opacity));
        $sizePercent = max(10, min(80, $sizePercent));

        try {
            $image = Image::make($imageAbsPath);
            $watermark = Image::make($watermarkAbsPath);

            $watermarkWidth = (int) ($image->width() * $sizePercent / 100);
            $watermark->resize($watermarkWidth, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $watermark->opacity($opacity);
            $image->insert($watermark, 'center');
            $image->save($imageAbsPath);

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

    public function applyToAll(): array
    {
        $result = ['processed' => 0, 'failed' => 0, 'skipped' => 0];

        if (!$this->isEnabled()) {
            return $result;
        }

        $images = KostImage::where('image_path', 'like', 'storage/kosts/%')->get();

        foreach ($images as $img) {
            $diskPath = str_replace('storage/', '', $img->image_path);

            if (!Storage::disk('public')->exists($diskPath)) {
                $result['skipped']++;
                continue;
            }

            $this->restoreOriginal($diskPath);

            if ($this->apply($diskPath)) {
                $result['processed']++;
            } else {
                $result['failed']++;
            }
        }

        return $result;
    }

    private function backupOriginal(string $diskPath): void
    {
        if (!str_starts_with($diskPath, 'kosts/')) {
            return;
        }

        $backupPath = str_replace('kosts/', 'kosts_original/', $diskPath);

        if (!Storage::disk('public')->exists($backupPath)) {
            Storage::disk('public')->copy($diskPath, $backupPath);
        }
    }

    private function restoreOriginal(string $diskPath): void
    {
        $backupPath = str_replace('kosts/', 'kosts_original/', $diskPath);

        if (Storage::disk('public')->exists($backupPath)) {
            Storage::disk('public')->copy($backupPath, $diskPath);
        }
    }
}
