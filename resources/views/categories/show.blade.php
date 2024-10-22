@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold mb-4">{{ $category->name }}</h1>
    <p class="mb-4">{{ $category->description }}</p>
    <h2 class="text-2xl font-semibold mb-2">Records in this category:</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($category->records as $record)
            <div class="bg-white p-4 rounded shadow">
                <h3 class="text-xl font-semibold">{{ $record->title }}</h3>
                <p>Holder: {{ $record->holder }}</p>
                <p>Value: {{ $record->value }}</p>
                <p>Date: {{ $record->record_date }}</p>
                <a href="{{ route('records.show', $record) }}" class="text-blue-600 hover:underline">View Details</a>
            </div>
        @endforeach
    </div>
    <a href="{{ route('categories.index') }}" class="mt-4 inline-block text-blue-600 hover:underline">Back to Categories</a>
@endsection