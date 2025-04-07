<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    private static $posts = [
        [
            'id' => 1,
            'title' => 'Learn PHP',
            'description' => 'PHP is a popular general-purpose scripting language that is especially suited to web development.',
            'posted_by' => 'Ahmed',
            'email' => 'ahmed@gmail.com',
            'created_at' => '2018-04-10',
        ],
        [
            'id' => 2,
            'title' => 'Solid Principles',
            'description' => 'The SOLID principles are a set of five design principles in object-oriented programming intended to make software designs more maintainable and flexible.',
            'posted_by' => 'Mohamed',
            'email' => 'mohamed@gmail.com',
            'created_at' => '2018-04-12',
        ],
        [
            'id' => 3,
            'title' => 'Design Patterns',
            'description' => 'Design patterns are typical solutions to common problems in software design. Each pattern is like a blueprint that you can customize to solve a particular design problem in your code.',
            'posted_by' => 'Ali',
            'email' => 'ali@gmail.com',
            'created_at' => '2018-04-13',
        ],
    ];

    private static $creators = ['Ahmed', 'Mohamed', 'Ali'];
    private static $creator_emails = [
        'Ahmed' => 'ahmed@gmail.com',
        'Mohamed' => 'mohamed@gmail.com',
        'Ali' => 'ali@gmail.com'
    ];

    public function index()
    {
        $posts = session('posts', self::$posts);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $creators = self::$creators;
        return view('posts.create', compact('creators'));
    }

    public function store(Request $request)
    {
        $posts = session('posts', self::$posts);


        // Generate a new ID (highest existing ID + 1)
        $newId = 1;
        if (!empty($posts)) {
            $newId = max(array_column($posts, 'id')) + 1;
        }

        // Create new post
        $newPost = [
            'id' => $newId,
            'title' => $request->title,
            'description' => $request->description,
            'posted_by' => $request->posted_by,
            'email' => self::$creator_emails[$request->posted_by] ?? $request->posted_by . '@gmail.com',
            'created_at' => date('Y-m-d'),
        ];

        // Add to posts array
        $posts[] = $newPost;

        // Store in session
        session(['posts' => $posts]);

        return redirect('/posts');
    }

    public function edit($id)
    {
        $posts = session('posts', self::$posts);

        // Find the post with the given ID
        $post = null;
        foreach ($posts as $p) {
            if ($p['id'] == $id) {
                $post = $p;
                break;
            }
        }

        // If post not found, redirect to posts list
        if (!$post) {
            return redirect('/posts');
        }

        $creators = self::$creators;

        return view('posts.edit', compact('post', 'creators'));
    }

    public function update(Request $request, $id)
    {
        $posts = session('posts', self::$posts);

        // Validate input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'posted_by' => 'required|string'
        ]);

        // Find the post index
        $postIndex = null;
        foreach ($posts as $index => $post) {
            if ($post['id'] == $id) {
                $postIndex = $index;
                break;
            }
        }

        // If post not found, redirect to posts list
        if ($postIndex === null) {
            return redirect('/posts');
        }

        // Update the post
        $posts[$postIndex]['title'] = $request->title;
        $posts[$postIndex]['description'] = $request->description;
        $posts[$postIndex]['posted_by'] = $request->posted_by;
        $posts[$postIndex]['email'] = self::$creator_emails[$request->posted_by] ?? $request->posted_by . '@gmail.com';

        // Store in session
        session(['posts' => $posts]);

        return redirect('/posts');
    }

    public function show($id)
    {
        $posts = session('posts', self::$posts);

        // Find the post with the given ID
        $post = null;
        foreach ($posts as $p) {
            if ($p['id'] == $id) {
                $post = $p;
                break;
            }
        }
        // If post not found, redirect to posts list
        if (!$post) {
            return redirect('/posts');
        }

        return view('posts.show', compact('post'));
    }

    public function destroy($id)
    {
        $posts = session('posts', self::$posts);


        //return all the posts except the one with the given ID
        $filteredPosts = array_filter($posts, function ($post) use ($id) {
            return $post['id'] != $id;
        });

        // Re-index array keys
        $filteredPosts = array_values($filteredPosts);

        session(['posts' => $filteredPosts]);

        return redirect('/posts');
    }
}
