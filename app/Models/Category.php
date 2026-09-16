<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'slug', 'emoji', 'color_from', 'color_to', 'description',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getGradientStyleAttribute(): string
    {
        return "linear-gradient(135deg, {$this->color_from}, {$this->color_to})";
    }
}
