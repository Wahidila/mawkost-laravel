<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    public function serve($path)
    {
        $path = str_replace('..', '', $path);

        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        $file = Storage::disk('public')->get($path);
        $mimeType = Storage::disk('public')->mimeType($path);
        $size = Storage::disk('public')->size($path);
        $lastModified = Storage::disk('public')->lastModified($path);
        $etag = md5($path . $lastModified . $size);

        return response($file, 200)
            ->header('Content-Type', $mimeType)
            ->header('Content-Length', $size)
            ->header('Cache-Control', 'public, max-age=86400, must-revalidate')
            ->header('Last-Modified', gmdate('D, d M Y H:i:s', $lastModified) . ' GMT')
            ->header('ETag', '"' . $etag . '"');
    }
}
