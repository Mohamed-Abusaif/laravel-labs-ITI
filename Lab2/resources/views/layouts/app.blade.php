<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ITI Blog')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <header class="bg-gray-800 text-white p-4">
        <div class="container mx-auto flex items-center">
            <h1 class="text-xl font-bold mr-6">ITI Blog</h1>
            <nav>
                <a href="/posts" class="text-white hover:text-gray-300">All Posts</a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto py-6 px-4">
        @yield('content')
    </main>
</body>

</html>