@extends('layouts.app')

@section('title', 'Edit Comment')

@section('content')
<div class="container mx-auto max-w-2xl my-8">
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title mb-6">Edit Comment</h2>
            
            <form action="{{ route('comments.update', $comment) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-control mb-6">
                    <label for="content" class="label">
                        <span class="label-text">Comment Content</span>
                    </label>
                    <textarea
                        id="content"
                        name="content"
                        rows="4"
                        class="textarea textarea-bordered @error('content') textarea-error @enderror"
                        required>{{ old('content', $comment->content) }}</textarea>
                    @error('content')
                        <div class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </div>
                    @enderror
                </div>
                
                <div class="card-actions justify-end">
                    <a href="{{ route('posts.show', $comment->commentable_id) }}" class="btn btn-ghost">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Comment</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 