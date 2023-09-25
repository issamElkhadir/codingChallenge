<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

/**
 * Class ImageUploadService.
 */
class ImageUploadService
{
    public function upload(UploadedFile $file, $destinationPath)
    {
        $filename = uniqid() . $file->getClientOriginalName();
        $file->move(public_path($destinationPath), $filename);
        return $filename;
    }
}
