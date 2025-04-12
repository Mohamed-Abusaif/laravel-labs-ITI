@extends('layouts.app')

@section('title', 'Lab 2 (Show Post)')

@section('content')
<div class="container mx-auto">
    <h1 class="text-4xl font-bold text-center mb-8">{{ $post->title }}</h1>

    <div class="breadcrumbs text-sm mb-6">
        <ul>
            <li><a href="{{ route('posts.index') }}">Posts</a></li>
            <li>{{ Str::limit($post->title, 30) }}</li>
        </ul>
    </div>

    @if(session('success'))
        <div role="alert" class="alert alert-success mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="flex flex-col md:flex-row gap-6 mb-8">
        <!-- Post Content -->
        <div class="md:w-2/3">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">Post Content</h2>
                    <div class="divider"></div>
                    <p class="whitespace-pre-line">{{ $post->content }}</p>
                    <div class="card-actions justify-end mt-4">
                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
                            </svg>
                            Edit
                        </a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-error">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Author Info -->
        <div class="md:w-1/3">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">Post Creator</h2>
                    <div class="divider"></div>
                    <div class="flex items-center gap-4 mb-4">
                        <div class="avatar placeholder">
                            <div class="bg-neutral text-neutral-content rounded-full w-12">
                                <span>{{ substr($post->user->name, 0, 1) }}</span>
                            </div>
                        </div>
                        <div>
                            <p class="font-bold">{{ $post->user->name }}</p>
                            <p class="text-sm opacity-70">{{ $post->user->email }}</p>
                        </div>
                    </div>
                    <div class="stat">
                        <div class="stat-title">Created at</div>
                        <div class="stat-value text-lg">{{ $post->created_at->format('Y-m-d') }}</div>
                        <div class="stat-desc">{{ $post->created_at->format('h:i A') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Comments Section -->
    <div class="card bg-base-100 shadow-xl mb-8">
        <div class="card-body">
            <h2 class="card-title">
                Comments 
                <div class="badge badge-primary badge-lg">{{ $post->comments->count() }}</div>
            </h2>
            <div class="divider"></div>

            <!-- Comment Form -->
            <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-6">
                @csrf
                <div class="form-control mb-4">
                    <label for="content" class="label">
                        <span class="label-text">Add a comment</span>
                    </label>
                    <textarea 
                        name="content" 
                        id="content" 
                        rows="3" 
                        class="textarea textarea-bordered @error('content') textarea-error @enderror"
                        required>{{ old('content') }}</textarea>
                    <input type="hidden" name="user_id" value="{{ $post->user_id }}">
                    @error('content')
                        <div class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Post Comment</button>
            </form>

            <!-- Comments List -->
            <div>
                @forelse($post->comments as $comment)
                    <div class="chat chat-start mb-4">
                        <div class="chat-image avatar placeholder">
                            <div class="bg-neutral text-neutral-content rounded-full w-10">
                                <span>{{ substr($comment->user->name, 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="chat-header">
                            {{ $comment->user->name }}
                            <time class="text-xs opacity-50 ml-1">{{ $comment->created_at->diffForHumans() }}</time>
                            <div class="dropdown dropdown-end dropdown-hover float-right">
                                <div tabindex="0" role="button" class="btn btn-xs btn-ghost btn-circle">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-4 h-4 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>
                                </div>
                                <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-32">
                                    <li><a href="{{ route('comments.edit', $comment) }}">Edit</a></li>
                                    <li>
                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full text-left text-error">Delete</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="chat-bubble">{{ $comment->content }}</div>
                    </div>
                @empty
                    <div class="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-info shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>No comments yet. Be the first to comment!</span>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="mb-8">
        <a href="{{ route('posts.index') }}" class="btn btn-outline">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
            </svg>
            Back to Posts
        </a>
    </div>
</div>
@endsection