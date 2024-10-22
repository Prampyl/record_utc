@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold mb-4">Categories</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($categories as $category)
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-xl font-semibold">{{ $category->name }}</h2>
                <p>{{ $category->description }}</p>
                <a href="{{ route('categories.show', $category) }}" class="text-blue-600 hover:underline">View Records</a>
            </div>
        @endforeach
    </div>
@endsection