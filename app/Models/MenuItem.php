<?php

namespace App\Models;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuItem extends Model
{
   use HasFactory;

    protected $fillable = [
        'menu_id',
        'title',
        'url',
        'target',
        'parent_id',
        'order'
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Secara otomatis mengisi menu_id untuk sub-item baru
        // berdasarkan menu_id dari induknya.
        static::creating(function ($menuItem) {
            if ($menuItem->parent_id && !$menuItem->menu_id) {
                if($menuItem->parent) {
                    $menuItem->menu_id = $menuItem->parent->menu_id;
                }
            }
        });
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('order');
    }
}
