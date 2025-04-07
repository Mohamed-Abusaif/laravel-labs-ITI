@extends('layouts.app')

@section('title', 'Lab 2 (Index & Pagination)')

@section('content')
<div class="container mx-auto">
    <h1 class="text-4xl font-bold text-center mb-8">Lab 2 (Index & Pagination)</h1>

    <div class="mb-6 flex justify-between items-center">
        <div class="breadcrumbs text-sm">
            <ul>
                <li><a>Home</a></li>
                <li>Posts</li>
            </ul>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('posts.index', ['trashed' => isset($showingTrashed) && $showingTrashed ? 0 : 1]) }}" class="btn {{ isset($showingTrashed) && $showingTrashed ? 'btn-primary' : 'btn-outline btn-primary' }}">
                {{ isset($showingTrashed) && $showingTrashed ? 'Show Active Posts' : 'Show Deleted Posts' }}
            </a>
            <a href="{{ route('posts.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Create Post
            </a>
        </div>
    </div>

    @if(session('success'))
        <div role="alert" class="alert alert-success mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Posted By</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->user->name }}</td>
                            <td>{{ $post->created_at->format('Y-m-d') }}</td>
                            <td class="flex gap-2">
                                @if(isset($showingTrashed) && $showingTrashed)
                                    <a href="{{ route('posts.restore', $post->id) }}" class="btn btn-success btn-sm">Restore</a>
                                @else
                                    <a href="{{ route('posts.show', $post) }}" class="btn btn-info btn-sm">View</a>
                                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-error btn-sm">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-6">
        {{ $posts->appends(request()->query())->links() }}
    </div>
</div>
@endsection