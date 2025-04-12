<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

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
     * Set the post's image.
     * 
     * This mutator handles automatic storage of uploaded files,
     * and cleanup of old files when updating.
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                // If value is an UploadedFile instance (from form upload)
                if ($value instanceof UploadedFile) {
                    // Delete old image if exists
                    if (isset($this->attributes['image']) && $this->attributes['image']) {
                        Storage::disk('public')->delete($this->attributes['image']);
                    }
                    
                    // Store new image and return path
                    return $value->store('posts', 'public');
                }
                
                return $value;
            },
        );
    }
    
    /**
     * Get the post's image URL.
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                if (!isset($attributes['image']) || empty($attributes['image'])) {
                    return null;
                }
                
                // The proper way to get URLs for public disk
                return asset('storage/' . $attributes['image']);
            },
        );
    }
    
    /**
     * Convert raw image path to URL
     * 
     * @return string|null
     */
    public function getImageUrlAttribute()
    {
        // This is a fallback accessor in case the Attribute class doesn't work
        if (!$this->attributes['image']) {
            return null;
        }
        
        return asset('storage/' . $this->attributes['image']);
    }
    
    /**
     * Delete the post's image from storage when the post is deleted.
     */
    protected static function booted()
    {
        static::deleting(function ($post) {
            if (isset($post->attributes['image']) && $post->attributes['image']) {
                Storage::disk('public')->delete($post->attributes['image']);
            }
        });
    }
}
