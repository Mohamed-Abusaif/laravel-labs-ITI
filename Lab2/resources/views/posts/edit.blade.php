@extends('layouts.app')

@section('title', 'Lab 1 (Edit & Update)')

@section('content')
<h1 class="text-4xl font-bold text-center text-red-600 mb-8">Lab 1 (Edit & Update)</h1>

<div class="max-w-2xl mx-auto">
    <form action="{{ route('posts.update', $post['id']) }}" method="POST">
        @csrf
        <div class="mb-6">
            <label for="title" class="block text-gray-700 mb-2">Title</label>
            <input
                type="text"
                id="title"
                name="title"
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                value="{{ $post['title'] }}"
                required>
        </div>

        <div class="mb-6">
            <label for="description" class="block text-gray-700 mb-2">Description</label>
            <textarea
                id="description"
                name="description"
                rows="6"
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                required>{{ $post['description'] }}</textarea>
        </div>

        <div class="mb-6">
            <label for="posted_by" class="block text-gray-700 mb-2">Post Creator</label>
            <select
                id="posted_by"
                name="posted_by"
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                required>
                @foreach($creators as $creator)
                <option value="{{ $creator }}" {{ $post['posted_by'] == $creator ? 'selected' : '' }}>{{ $creator }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <button
                type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                Update
            </button>
        </div>
    </form>
</div>
@endsection