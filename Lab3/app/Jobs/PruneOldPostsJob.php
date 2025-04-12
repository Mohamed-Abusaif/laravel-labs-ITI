<?php

namespace App\Jobs;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PruneOldPostsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Calculate the date 2 years ago
        $twoYearsAgo = Carbon::now()->subYears(2);
        
        // Get posts older than 2 years that haven't been deleted
        $oldPosts = Post::where('created_at', '<', $twoYearsAgo)->get();
        
        $count = $oldPosts->count();
        
        // Delete each post
        foreach ($oldPosts as $post) {
            // Delete associated image if exists
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            
            // Delete the post
            $post->delete();
        }
        
        Log::info("PruneOldPostsJob: {$count} posts older than 2 years were deleted.");
    }
}
