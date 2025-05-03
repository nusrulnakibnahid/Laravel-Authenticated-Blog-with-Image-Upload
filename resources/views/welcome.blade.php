<!-- resources/views/welcome.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ostad Batch 6 Blog - Posts</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Navbar -->
<nav class="bg-white shadow-md">
    <div class="container max-w-screen-xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="text-xl font-bold text-blue-600">Ostad B6 Blog</a>
            <div class="space-x-4">
                {{-- <a href="/" class="text-gray-700 hover:text-blue-600">Home</a>
                <a href="/dashboard" class="text-gray-700 hover:text-blue-600">About</a> --}}
                @auth
                    <span class="text-gray-700">{{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button class="text-red-500 hover:underline ml-2">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Login</a>
                    <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="bg-cover bg-center text-white text-center py-20" style="background-image: url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1470&q=80');">
        <div class="bg-black bg-opacity-50 py-12 px-4">
            <h1 class="text-4xl font-bold">Welcome to Our Blog</h1>
            <p class="mt-2 text-lg">Discover the latest posts from our awesome authors!</p>
        </div>
    </header>
    

    <!-- Post List -->
    <main class="container mx-auto px-6 py-10">
        <h2 class="text-2xl font-semibold mb-6 border-b pb-2">Latest Posts</h2>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($posts as $post)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition duration-300">
                    <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" class="rounded-t-lg w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-2">{{ $post->title }}</h3>
                        <p class="text-sm text-gray-500 mb-2">By {{ $post->user->name }} &middot; {{ $post->created_at->diffForHumans() }}</p>
                        
                        {{-- Content preview --}}
                        <p class="text-sm text-gray-700 mb-2">
                            {{ Str::limit(strip_tags($post->content), 100, '...') }}
                        </p>
        
                        {{-- Read More --}}
                        <a href="{{ route('posts.show', $post->id) }}" class="text-blue-600 hover:underline text-sm">Read more...</a>

        
                        <p class="text-xs text-gray-400 mt-2">Posted on {{ $post->created_at->format('d M, Y h:i A') }}</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-600">No posts available.</p>
            @endforelse
        </div>
        
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow-inner mt-12">
        <div class="container mx-auto px-6 py-4 text-center text-sm text-gray-600">
            &copy; {{ date('Y') }} Ostad Betch 6 Blog. All rights reserved.
        </div>
    </footer>

</body>
</html>
