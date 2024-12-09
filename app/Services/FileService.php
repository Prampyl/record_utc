<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class FileService
{
    public function handleUpload($file, $path = 'uploads')
    {
        $fileName = time() . '_' . $file->getClientOriginalName();
        
        if (str_starts_with($file->getMimeType(), 'image/')) {
            return $this->handleImage($file, $fileName, $path);
        }
        
        return $this->handleFile($file, $fileName, $path);
    }

    private function handleImage($file, $fileName, $path)
    {
        $image = Image::make($file);
        
        // Resize large images
        if ($image->width() > 1200) {
            $image->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }
        
        // Create thumbnail
        $thumbnail = $image->fit(300, 300);
        Storage::disk('public')->put(
            "{$path}/thumbnails/{$fileName}",
            $thumbnail->encode('jpg', 80)
        );
        
        // Save optimized original
        Storage::disk('public')->put(
            "{$path}/{$fileName}",
            $image->encode('jpg', 80)
        );
        
        return [
            'path' => "{$path}/{$fileName}",
            'thumbnail' => "{$path}/thumbnails/{$fileName}"
        ];
    }

    private function handleFile($file, $fileName, $path)
    {
        $filePath = Storage::disk('public')->putFileAs($path, $file, $fileName);
        return ['path' => $filePath];
    }

    public function deleteFile($path)
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
        
        // Delete thumbnail if exists
        $thumbnailPath = str_replace('uploads/', 'uploads/thumbnails/', $path);
        if (Storage::disk('public')->exists($thumbnailPath)) {
            Storage::disk('public')->delete($thumbnailPath);
        }
    }
}