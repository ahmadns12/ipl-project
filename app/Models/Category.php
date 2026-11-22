<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['nama_kategori', 'slug'];

    protected static function booted(): void
    {
        static::saving(function (Category $category) {
            if (blank($category->slug)) {
                $category->slug = Str::slug($category->nama_kategori);
            }
        });
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'id_kategori');
    }
}