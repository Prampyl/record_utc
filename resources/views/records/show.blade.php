@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold mb-4">{{ $record->title }}</h1>
    <div class="bg-white p-4 rounded shadow">
        <p><strong>Holder:</strong> {{ $record->holder }}</p>
        <p><strong>Value:</strong> {{ $record->value }}</p>
        <p><strong>Date:</strong> {{ $record->record_date }}</p>
        <p><strong>Category:</strong> {{ $record->category->name }}</p>
        <p><strong>Description:</strong> {{ $record->description }}</p>
        @if($record->image_url)
            <img src="{{ $record->image_url }}" alt="{{ $record->title }}" class="mt-4 max-w-full h-auto">
        @endif
    </div>
    <a href="{{ route('records.index') }}" class="mt-4 inline-block text-blue-600 hover:underline">Back to Records</a>
@endsection