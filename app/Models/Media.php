<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Media extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'media';

    protected $fillable = [
        'uuid',
        'collection_name',
        'name',
        'file_name',
        'mime_type',
        'disk',
        'conversions_disk',
        'size',
        'order_column',
        'created_at',
        'updated_at',
        'file_path',

        'model_type',
        'model_id',
        'manipulations',
        'custom_properties',
        'generated_conversions',
        'responsive_images'
    ];

    protected $casts = [
        'uuid' => 'string',
    ];

    // Если нужны отношения, добавьте их здесь
    public function model()
    {
        return $this->morphTo();
    }
}
