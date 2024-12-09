@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold mb-4">Create New Record</h1>
    
    <form action="{{ route('records.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Holder</label>
                <input type="text" name="holder" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Value</label>
                <input type="text" name="value" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Date</label>
                <input type="date" name="record_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Category</label>
                <select name="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    @foreach(\App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Upload Files</label>
                <input type="file" name="files[]" multiple 
                       accept="video/*,image/*,.pdf,.doc,.docx" 
                       class="mt-1 block w-full" required>
                <p class="mt-1 text-sm text-gray-500">
                    Supported formats: Images, Videos, PDF, DOC
                </p>
            </div>
            
            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    Create Record
                </button>
            </div>
        </div>
    </form>
</div>
@endsection