<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\FileService;

class Record extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'holder', 'value', 'record_date', 'description', 'category_id', 'user_id'];

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();
        
        static::deleting(function ($record) {
            foreach ($record->media as $media) {
                app(FileService::class)->deleteFile($media->file_path);
                $media->delete();
            }
        });
    }
}