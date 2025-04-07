@extends('layouts.app')

@section('title', 'Delete Post Confirmation')

@section('content')
<div class="container mx-auto max-w-2xl my-8">
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title text-center text-error mb-6">Delete Post Confirmation</h2>
            
            <div class="alert alert-warning mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                <div>
                    <h3 class="font-bold">Warning!</h3>
                    <div class="text-sm">Are you sure you want to delete this post? This action cannot be undone.</div>
                </div>
            </div>
            
            <div class="mb-6">
                <h3 class="font-bold text-lg mb-2">Post Details:</h3>
                <div class="stats shadow w-full">
                    <div class="stat">
                        <div class="stat-title">Title</div>
                        <div class="stat-value text-lg">{{ $post->title }}</div>
                    </div>
                    <div class="stat">
                        <div class="stat-title">Created by</div>
                        <div class="stat-value text-lg">{{ $post->user->name }}</div>
                        <div class="stat-desc">{{ $post->created_at->format('Y-m-d H:i') }}</div>
                    </div>
                </div>
            </div>
            
            <div class="card-actions justify-end">
                <a href="{{ route('posts.show', $post) }}" class="btn btn-ghost">Cancel</a>
                <form action="{{ route('posts.destroy', $post) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="confirm" value="yes">
                    <button type="submit" class="btn btn-error">Confirm Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 