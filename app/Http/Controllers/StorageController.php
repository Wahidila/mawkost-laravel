<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

/**
 * Serves files from storage/app/public when the storage:link symlink
 * is missing or broken (common on shared hosting like Hostinger).
 */
class StorageController extends Controller
{
    public function serve($path)
    {
        // Security: prevent directory traversal
        $path = str_replace('..', '', $path);

        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        $file = Storage::disk('public')->get($path);
        $mimeType = Storage::disk('public')->mimeType($path);
        $size = Storage::disk('public')->size($path);
        $lastModified = Storage::disk('public')->lastModified($path);

        return response($file, 200)
            ->header('Content-Type', $mimeType)
            ->header('Content-Length', $size)
            ->header('Cache-Control', 'public, max-age=31536000')
            ->header('Last-Modified', gmdate('D, d M Y H:i:s', $lastModified) . ' GMT');
    }
}
