<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $post->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white shadow">
        <div class="max-w-screen-xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="text-xl font-bold text-blue-600">Ostad B6 Blog</a>
            <a href="/" class="text-gray-700 hover:text-blue-600">← Back to Home</a>
        </div>
    </nav>

    <!-- Post Detail -->
    <main class="max-w-3xl mx-auto mt-10 bg-white shadow rounded-lg p-6">
        <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" class="w-full rounded mb-4">

        <h1 class="text-2xl font-bold mb-2">{{ $post->title }}</h1>
        <p class="text-gray-600 text-sm mb-4">By {{ $post->user->name }} • {{ $post->created_at->format('d M, Y h:i A') }}</p>

        <div class="text-gray-800 leading-relaxed">
            {!! nl2br(e($post->content)) !!}
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white text-center text-sm py-4 mt-10">
        &copy; {{ date('Y') }} Ostad B6 Blog. All rights reserved.
    </footer>

</body>
</html>
