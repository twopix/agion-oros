<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

class Menu extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'parent_id',
        'name',
        'lang',
        'link',
        'type',
        'data',
        'target',
        'order',
        'mobile',
        'icon'
    ];

    protected $casts = [
        'data' => 'array',
        'mobile' => 'integer',
        'order' => 'integer'
    ];

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    public function scopeActive($query) 
    {
        return $query->where('activated', 'f');
    }

    public function name()
    {
        return $this->{'name'};
    }

    public function icon()
    {
        return $this->icon;
    }

    public function link()
    {
        return $this->link;
    }

    public static function getMenu($parentId = 0)
    {
        $menuItems = self::where('parent_id', $parentId)->active()->get();
        $result = new Collection();

        foreach ($menuItems as $item) {
            $item->name = $item->name();
            $item->link = $item->link();
            $item->icon = $item->icon();
            $item->children = self::getMenu($item->id);

            $result->push($item);
        }

        return $result;
    }
}
