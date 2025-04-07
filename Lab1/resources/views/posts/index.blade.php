@extends('layouts.app')

@section('title', 'Lab 1 (Index & Destroy)')

@section('content')
<h1 class="text-4xl font-bold text-center text-red-600 mb-8">Lab 1 (Index & Destroy)</h1>

<div class="mb-6 text-right">
    <a href="{{ route('posts.create') }}" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded">Create Post</a>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full">
        <thead>
            <tr class="border-b">
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posted By</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($posts as $post)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">{{ $post['id'] }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $post['title'] }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $post['posted_by'] }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $post['created_at'] }}</td>
                <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
                    <a href="{{ route('posts.show', $post['id']) }}" class="bg-cyan-500 hover:bg-cyan-600 text-white py-1 px-2 rounded">View</a>
                    <a href="{{ route('posts.edit', $post['id']) }}" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-2 rounded">Edit</a>
                    <a href="{{ route('posts.destroy', $post['id']) }}" class="bg-red-500 hover:bg-red-600 text-white py-1 px-2 rounded">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6">
    <p class="text-red-500 font-bold">Pagination in lab 2</p>
</div>
@endsection