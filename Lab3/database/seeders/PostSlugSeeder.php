<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSlugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all posts including soft-deleted ones
        $posts = Post::withTrashed()->get();
        
        foreach ($posts as $post) {
            // Force the model to regenerate the slug
            $post->slug = null;
            
            // Save without triggering model events
            $post->saveQuietly();
            
            // Now save with events to generate the slug
            $post->save();
            
            $this->command->info("Updated slug for post ID: {$post->id} - New slug: {$post->slug}");
        }
        
        $this->command->info('All posts have been updated with slugs!');
    }
}
