<?php

namespace App\Models;

use Filament\Navigation\MenuItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'location'];

    // Relasi ini mengambil SEMUA item, akan kita filter nanti di Service Provider
    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class)->orderBy('order');
    }

    // Relasi ini tetap ada untuk Repeater di Filament
    public function menuItems(): HasMany
    {
        return $this->hasMany(\App\Models\MenuItem::class)->whereNull('parent_id')->orderBy('order');
    }
}
