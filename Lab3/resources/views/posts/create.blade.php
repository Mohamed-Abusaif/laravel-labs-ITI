@extends('layouts.app')

@section('title', 'Lab 2 (Create Post)')

@section('content')
<div class="container mx-auto">
    <h1 class="text-4xl font-bold text-center mb-8">Create New Post</h1>

    <div class="breadcrumbs text-sm mb-6">
        <ul>
            <li><a href="{{ route('posts.index') }}">Posts</a></li>
            <li>Create</li>
        </ul>
    </div>

    <div class="card bg-base-100 shadow-xl mx-auto max-w-2xl">
        <div class="card-body">
            <h2 class="card-title mb-4">New Post Details</h2>
            
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-control mb-4">
                    <label for="title" class="label">
                        <span class="label-text">Title</span>
                    </label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        class="input input-bordered @error('title') input-error @enderror"
                        value="{{ old('title') }}"
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
                        required>{{ old('content') }}</textarea>
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
                    <input
                        type="file"
                        id="image"
                        name="image"
                        accept=".jpg, .jpeg, .png"
                        class="file-input file-input-bordered w-full @error('image') input-error @enderror">
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
                        <option value="" disabled selected>Select user</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <div class="card-actions justify-end">
                    <a href="{{ route('posts.index') }}" class="btn btn-ghost">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Post</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection