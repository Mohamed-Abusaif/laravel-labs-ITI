<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory, SoftDeletes, Sluggable;
    
    protected $fillable = ['title', 'content', 'user_id', 'slug', 'image'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
    
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    
    /**
     * Get the post's image URL.
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                if (!isset($attributes['image']) || is_null($attributes['image'])) {
                    return null;
                }
                return Storage::disk('public')->url($attributes['image']);
            },
        );
    }
    
    /**
     * Delete the post's image from storage when the post is deleted.
     */
    protected static function booted()
    {
        static::deleting(function ($post) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
        });
    }
}
