<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Records</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 p-4 text-white">
        <div class="container mx-auto">
            <a href="{{ route('home') }}" class="text-2xl font-bold">School Records</a>
            <a href="{{ route('categories.index') }}" class="ml-4">Categories</a>
            <a href="{{ route('records.index') }}" class="ml-4">Records</a>
        </div>
    </nav>

    <main class="container mx-auto mt-8">
        @yield('content')
    </main>
</body>
</html>