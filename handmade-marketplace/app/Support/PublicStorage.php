<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

/**
 * Reliable public disk URLs for uploaded files (products, shop logos).
 * Uses asset('storage/...') so images work whenever `php artisan storage:link` exists.
 */
class PublicStorage
{
    public static function url(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        $path = ltrim(str_replace(['storage/', 'public/'], '', $path), '/');

        if ($path === '' || ! Storage::disk('public')->exists($path)) {
            return null;
        }

        return asset('storage/'.$path);
    }
}
