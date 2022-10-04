<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'feature' => 'boolean'
    ];

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

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(500)
            ->height(450)
            ->format('jpg');

        $this->addMediaConversion('placeholder')
            ->optimize()
            ->format('jpg')
            ->width(10)
            ->blur(10)
            ->performOnCollections('cover');
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
