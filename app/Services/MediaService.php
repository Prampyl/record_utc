<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use FFMpeg;

class MediaService
{   
    public function store(UploadedFile $file, $model, $collection = 'default')
    {
    $fileName = time() . '_' . $file->getClientOriginalName();
    $filePath = "uploads/{$collection}";
    
    $processingResult = null;
    
    if (str_starts_with($file->getMimeType(), 'image/')) {
        $processingResult = $this->handleImage($file, $fileName, $filePath);
    } elseif (str_starts_with($file->getMimeType(), 'video/')) {
        $processingResult = $this->handleVideo($file, $fileName, $filePath);
    } else {
        $this->handleDocument($file, $fileName, $filePath);
    }

    $mediaData = [
        'file_name' => $fileName,
        'file_path' => "{$filePath}/{$fileName}",
        'file_size' => $file->getSize(),
        'mime_type' => $file->getMimeType(),
        'collection_name' => $collection,
        'mediable_id' => $model->id,
        'mediable_type' => get_class($model)
    ];

    if ($processingResult) {
        $mediaData = array_merge($mediaData, [
            'thumbnail_path' => $processingResult['thumbnail_path'] ?? null,
            'optimized_path' => $processingResult['optimized_path'] ?? null
        ]);
    }

    return Media::create($mediaData);
    }

    private function handleImage(UploadedFile $file, string $fileName, string $filePath)
    {
        $image = Image::make($file);
        
        // Create thumbnail
        $thumbnail = clone $image;
        $thumbnail->fit(300, 300);
        Storage::disk('public')->put(
            "{$filePath}/thumbnails/{$fileName}",
            (string) $thumbnail->encode('jpg', 80)
        );
        
        // Resize original if needed
        if ($image->width() > 1200) {
            $image->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        // Save optimized original
        Storage::disk('public')->put(
            "{$filePath}/{$fileName}",
            (string) $image->encode('jpg', 80)
        );
    }

    private function handleVideo(UploadedFile $file, string $fileName, string $filePath)
    {
        // Store original video first
        Storage::disk('public')->putFileAs(
            $filePath,
            $file,
            $fileName
        );

        try {
            // Debug log
            \Log::info('Starting video processing', [
                'fileName' => $fileName,
                'mimeType' => $file->getMimeType()
            ]);

            // Check if FFMpeg is installed
            $ffmpegPath = exec('which ffmpeg');
            \Log::info('FFMpeg path: ' . $ffmpegPath);

            $ffmpeg = FFMpeg\FFMpeg::create([
                'ffmpeg.binaries'  => $ffmpegPath,
                'timeout'          => 3600,
                'ffmpeg.threads'   => 12,
            ]);

            $video = $ffmpeg->open(Storage::disk('public')->path("{$filePath}/{$fileName}"));

            // Generate thumbnail
            $thumbnailPath = "{$filePath}/thumbnails/{$fileName}.jpg";
            $video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(1))
                ->save(Storage::disk('public')->path($thumbnailPath));

            // Convert to web-optimized format
            $format = new FFMpeg\Format\Video\X264();
            $format->setKiloBitrate(1000)
                ->setAudioKiloBitrate(128);

            $optimizedFileName = pathinfo($fileName, PATHINFO_FILENAME) . '_optimized.mp4';
            $optimizedPath = "{$filePath}/{$optimizedFileName}";
            
            $video->save($format, Storage::disk('public')->path($optimizedPath));

            return [
                'thumbnail_path' => $thumbnailPath,
                'optimized_path' => $optimizedPath
            ];
        } catch (\Exception $e) {
            \Log::error('Video processing failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Return the original file path without processing
            return [
                'file_path' => "{$filePath}/{$fileName}",
                'thumbnail_path' => null,
                'optimized_path' => null
            ];
        }
    }

    private function handleDocument(UploadedFile $file, string $fileName, string $filePath)
    {
        Storage::disk('public')->putFileAs(
            $filePath,
            $file,
            $fileName
        );
    }

    public function delete(Media $media)
    {
        $basePath = $media->file_path;
        $thumbnailPath = str_replace($media->file_name, 'thumbnails/' . $media->file_name, $basePath);

        // Delete original file
        if (Storage::disk('public')->exists($basePath)) {
            Storage::disk('public')->delete($basePath);
        }

        // Delete thumbnail if exists
        if (Storage::disk('public')->exists($thumbnailPath)) {
            Storage::disk('public')->delete($thumbnailPath);
        }

        // Delete database record
        $media->delete();
    }
}
