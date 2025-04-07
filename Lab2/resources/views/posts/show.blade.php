@extends('layouts.app')

@section('title', 'Lab 1 (Show)')

@section('content')
<h1 class="text-4xl font-bold text-center text-red-600 mb-8">Lab 1 (Show)</h1>

<div class="max-w-3xl mx-auto mb-6">
    <div class="bg-gray-100 p-4 mb-6">
        <h2 class="text-lg font-semibold">Post Info</h2>
    </div>

    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <div class="mb-4">
            <span class="font-bold">Title :</span>
            <span>{{ $post['title'] }}</span>
        </div>

        <div>
            <span class="font-bold">Description :</span>
            <p class="mt-2">{{ $post['description'] }}</p>
            <p class="text-gray-600 mt-2">With supporting text below as a natural lead-in to additional content.</p>
        </div>
    </div>

    <div class="bg-gray-100 p-4 mb-6">
        <h2 class="text-lg font-semibold">Post Creator Info</h2>
    </div>

    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <div class="mb-4">
            <span class="font-bold">Name :</span>
            <span>{{ $post['posted_by'] }}</span>
        </div>

        <div class="mb-4">
            <span class="font-bold">Email :</span>
            <span>{{ $post['email'] }}</span>
        </div>

        <div>
            <span class="font-bold">Created At :</span>
            <span>{{ date('l jS \o\f F Y h:i:s A', strtotime($post['created_at'])) }}</span>

        </div>
    </div>


</div>
@endsection