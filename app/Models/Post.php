<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted()
    {
        parent::booted();
        static::created(function (Post $post) {
            $post->update(['slug' => Str::slug($post->title)  . '-' . $post->id]);
        });
        static::updating(function (Post $post) {
            $post->slug = Str::slug($post->title)  . '-' . $post->id;
        });

    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function last_update_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_update_user_id');
    }
}
