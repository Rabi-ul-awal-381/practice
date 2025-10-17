@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-10">
    <h1 class="text-3xl font-bold mb-6">Add Category</h1>

    <form action="{{ route('admin.categories.store') }}" method="POST" class="bg-white p-6 rounded shadow max-w-lg">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Category Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-indigo-500">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Description</label>
            <textarea name="description" rows="3" class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-indigo-500">{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">Create Category</button>
    </form>
</div>
@endsection
