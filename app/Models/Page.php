<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Page extends Model
{
    use SoftDeletes;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'intro',
        'content',
        'type',
        'menu_id',
        'featured_image',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'meta_og_image',
        'meta_og_url',
        'hits',
        'order',
        'status'
    ];

    protected $casts = [
        'meta_keywords' => 'array',
        'meta_description' => 'array',
        'hits' => 'integer',
        'order' => 'integer',
        'status' => 'integer'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}

