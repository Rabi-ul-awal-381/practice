@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-10">
    <h1 class="text-3xl font-bold mb-6">Categories</h1>



    <div class="mb-4">
        <a href="{{ route('admin.categories.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Add New Category</a>
    </div>

    <table class="w-full bg-white shadow rounded overflow-hidden">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-3">Name</th>
                <th class="p-3">Description</th>
                <th class="p-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr class="border-b">
                <td class="p-3">{{ $category->name }}</td>
                <td class="p-3">{{ $category->description }}</td>
                <td class="p-3 text-right space-x-2">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600 hover:underline">Edit</a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Delete this category?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $categories->links() }}
    </div>
</div>
@endsection
