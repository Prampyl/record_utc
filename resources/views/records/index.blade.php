@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold mb-4">Records</h1>
    <div class="mb-4">
        <a href="{{ route('records.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            Create New Record
        </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($records as $record)
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-xl font-semibold">{{ $record->title }}</h2>
                <p>Holder: {{ $record->holder }}</p>
                <p>Value: {{ $record->value }}</p>
                <p>Date: {{ $record->record_date }}</p>
                <p>Category: {{ $record->category->name }}</p>
                <a href="{{ route('records.show', $record) }}" class="text-blue-600 hover:underline">View Details</a>
            </div>
        @endforeach
    </div>
    <div class="mt-4">
        {{ $records->links() }}
    </div>
@endsection