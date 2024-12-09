@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold mb-4">{{ $record->title }}</h1>
    
    <!-- Record Details -->
    <div class="mb-6">
        <p class="mb-2"><strong>Holder:</strong> {{ $record->holder }}</p>
        <p class="mb-2"><strong>Value:</strong> {{ $record->value }}</p>
        <p class="mb-2"><strong>Date:</strong> {{ $record->record_date }}</p>
        <p class="mb-2"><strong>Category:</strong> {{ $record->category->name }}</p>
        <p class="mb-4"><strong>Description:</strong> {{ $record->description }}</p>
    </div>

    <!-- Media Gallery -->
    @if($record->media->count() > 0)
        <div class="border-t pt-4">
            <h2 class="text-xl font-semibold mb-4">Attachments</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($record->media as $media)
                    <div class="relative group">
                        @if(str_starts_with($media->mime_type, 'image/'))
                            <img src="{{ Storage::url($media->file_path) }}" 
                                 alt="{{ $media->file_name }}"
                                 class="w-full h-48 object-cover rounded shadow-sm hover:shadow-lg transition-shadow">
                                 @elseif(str_starts_with($media->mime_type, 'video/'))
                                    <div class="relative group">
                                        <video controls 
                                            class="w-full h-48 object-cover rounded shadow-sm hover:shadow-lg transition-shadow">
                                            <source src="{{ Storage::url($media->file_path) }}" type="{{ $media->mime_type }}">
                                            Your browser does not support the video tag.
                                        </video>
                                        @if($media->thumbnail_path)
                                            <img src="{{ Storage::url($media->thumbnail_path) }}" 
                                                alt="Video thumbnail" 
                                                class="absolute inset-0 w-full h-full object-cover opacity-0 group-hover:opacity-100 transition-opacity">
                                        @endif
                                    </div>
                        @else
                            <a href="{{ Storage::url($media->file_path) }}" 
                               target="_blank"
                               class="flex items-center justify-center w-full h-48 bg-gray-100 rounded shadow-sm hover:shadow-lg transition-shadow">
                                <div class="text-center">
                                    <i class="fas fa-file text-4xl text-gray-400"></i>
                                    <p class="mt-2 text-sm text-gray-600">{{ $media->file_name }}</p>
                                </div>
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<div class="mt-4">
    <a href="{{ route('records.index') }}" class="inline-block text-blue-600 hover:underline">
        &larr; Back to Records
    </a>
</div>
@endsection