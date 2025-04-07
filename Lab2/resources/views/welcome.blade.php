@extends('layouts.app')

@section('title', 'Welcome to ITI Blog - Lab 1')

@section('content')
<div class="text-center">
    <h1 class="text-4xl font-bold text-red-600 mb-6">Welcome to ITI Blog</h1>
    <p class="text-xl mb-8">A simple blog system built with Laravel</p>

    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Lab 1 Introduction</h2>

        <div class="space-y-4 text-left">
            <div>
                <h3 class="font-bold text-lg text-gray-800">Current Features:</h3>
                <ul class="list-disc pl-6 mt-2">
                    <li>Index page listing all posts</li>
                    <li>Delete functionality for posts</li>
                    <li>Clean UI with Tailwind CSS</li>
                    <li>Array-based data storage system</li>
                </ul>
            </div>

            <div>
                <h3 class="font-bold text-lg text-gray-800">Lab 1 Focus:</h3>
                <ul class="list-disc pl-6 mt-2">
                    <li>CRUD operations on Posts</li>
                    <li>Implementation of Resource Controller</li>
                    <li>Using blade layout to avoid navbar duplication</li>
                    <li>Proper form submissions with redirects</li>
                </ul>
            </div>
        </div>

        <div class="mt-8">
            <a href="/posts" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-6 rounded-lg inline-block">
                View All Posts
            </a>
        </div>
    </div>

</div>
@endsection