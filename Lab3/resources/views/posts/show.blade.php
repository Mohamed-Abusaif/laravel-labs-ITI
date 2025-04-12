@extends('layouts.app')

@section('title', 'Lab 2 (View Post)')

@section('content')
<div class="container mx-auto">
    <h1 class="text-4xl font-bold text-center mb-8">View Post</h1>

    <div class="mb-6 flex justify-between items-center">
        <div class="breadcrumbs text-sm">
            <ul>
                <li><a href="{{ route('posts.index') }}">Posts</a></li>
                <li>View</li>
            </ul>
        </div>
        <div>
            <a href="{{ route('posts.index') }}" class="btn btn-outline btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                </svg>
                Back to List
            </a>
        </div>
    </div>

    @if(session('success'))
        <div role="alert" class="alert alert-success mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="card bg-base-100 shadow-xl mb-6">
        <div class="card-body">
            <h2 class="card-title text-2xl">{{ $post->title }}</h2>
            
            @if($post->image)
            <figure class="my-4">
                <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="rounded-lg max-w-full md:max-w-lg shadow-md">
            </figure>
            @endif
            
            <div class="whitespace-pre-line">{{ $post->content }}</div>
            
            <div class="flex justify-between items-center mt-4">
                <div class="flex items-center">
                    <div class="avatar placeholder mr-2">
                        <div class="bg-neutral text-neutral-content rounded-full w-8">
                            <span>{{ substr($post->user->name, 0, 1) }}</span>
                        </div>
                    </div>
                    <div>
                        <div class="font-medium">{{ $post->user->name }}</div>
                        <div class="text-sm opacity-50">{{ $post->created_at->format('M d, Y') }}</div>
                    </div>
                </div>
                <div class="card-actions">
                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-primary btn-sm">Edit</a>
                    <a href="{{ route('posts.destroy', $post) }}" class="btn btn-error btn-sm">Delete</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Comments Section -->
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">Comments</h2>
            <div class="divider"></div>
            
            @if($post->comments->count() > 0)
                @foreach($post->comments as $comment)
                <div class="border-b last:border-b-0 py-4">
                    <div class="flex items-start gap-2">
                        <div class="avatar placeholder">
                            <div class="bg-neutral text-neutral-content rounded-full w-8">
                                <span>{{ substr($comment->user->name, 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-bold">{{ $comment->user->name }}</p>
                                    <p class="text-xs opacity-70">{{ $comment->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="flex gap-1">
                                    <button class="btn btn-ghost btn-xs">Edit</button>
                                    <button class="btn btn-ghost btn-xs text-error">Delete</button>
                                </div>
                            </div>
                            <p class="mt-2">{{ $comment->content }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-info shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>No comments yet. Be the first to comment!</span>
                </div>
            @endif
            
            <!-- Add Comment Form -->
            <form class="mt-6">
                <div class="form-control">
                    <label for="comment" class="label">
                        <span class="label-text font-bold">Add a Comment</span>
                    </label>
                    <textarea id="comment" name="comment" rows="4" class="textarea textarea-bordered" placeholder="Write your comment here..."></textarea>
                </div>
                <div class="form-control mt-2">
                    <button type="submit" class="btn btn-primary">Submit Comment</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection