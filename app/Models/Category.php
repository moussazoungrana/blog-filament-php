<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected static function booted()
    {
        parent::booted();
        static::created(function (Category $category) {
            $category->update(['slug' => Str::slug($category->name) . '-' . $category->id]);
        });
        static::updating(function (Category $category) {
            $category->slug = Str::slug($category->name) . '-' . $category->id;
        });
    }


    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'category_id');
    }


}
