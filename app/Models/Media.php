<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'file_name',
        'file_path',
        'file_size',
        'mime_type',
        'collection_name',
        'thumbnail_path',
        'optimized_path',
        'mediable_id',
        'mediable_type'
    ];

    public function mediable()
    {
        return $this->morphTo();
    }
}

