@extends('layouts.app')

@section('title', 'Lab 2 (Edit Post)')

@section('content')
<div class="container mx-auto">
    <h1 class="text-4xl font-bold text-center mb-8">Edit Post</h1>

    <div class="breadcrumbs text-sm mb-6">
        <ul>
            <li><a href="{{ route('posts.index') }}">Posts</a></li>
            <li><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></li>
            <li>Edit</li>
        </ul>
    </div>

    <div class="card bg-base-100 shadow-xl mx-auto max-w-2xl">
        <div class="card-body">
            <h2 class="card-title mb-4">Edit Post Details</h2>
            
            <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-control mb-4">
                    <label for="title" class="label">
                        <span class="label-text">Title</span>
                    </label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        class="input input-bordered @error('title') input-error @enderror"
                        value="{{ old('title', $post->title) }}"
                        required>
                    @error('title')
                        <div class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <div class="form-control mb-4">
                    <label for="content" class="label">
                        <span class="label-text">Content</span>
                    </label>
                    <textarea
                        id="content"
                        name="content"
                        rows="6"
                        class="textarea textarea-bordered @error('content') textarea-error @enderror"
                        required>{{ old('content', $post->content) }}</textarea>
                    @error('content')
                        <div class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </div>
                    @enderror
                </div>
                
                <div class="form-control mb-4">
                    <label for="image" class="label">
                        <span class="label-text">Image (JPG, PNG)</span>
                    </label>
                    
                    @if($post->image)
                    <div class="mb-2">
                        <img src="{{ $post->image_url ?? $post->getImageUrlAttribute() }}" alt="{{ $post->title }}" class="max-w-xs rounded-lg shadow-md">
                        <div class="mt-1 text-sm text-gray-500">Current image</div>
                    </div>
                    @endif
                    
                    <input
                        type="file"
                        id="image"
                        name="image"
                        accept=".jpg, .jpeg, .png"
                        class="file-input file-input-bordered w-full @error('image') input-error @enderror">
                    <div class="mt-1 text-sm text-gray-500">Leave empty to keep the current image</div>
                    @error('image')
                        <div class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <div class="form-control mb-6">
                    <label for="user_id" class="label">
                        <span class="label-text">Post Creator</span>
                    </label>
                    <select
                        id="user_id"
                        name="user_id"
                        class="select select-bordered w-full @error('user_id') select-error @enderror"
                        required>
                        <option value="" disabled>Select user</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $post->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <div class="card-actions justify-end">
                    <a href="{{ route('posts.show', $post) }}" class="btn btn-ghost">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Post</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection