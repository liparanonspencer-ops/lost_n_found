@extends('layouts.app')
@section('header')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Report Lost or Found Item
        </h2>
    @endsection
    @section('content')
    <div class="py-12">
          <a href="{{ route('items.index') }}" 
   class="inline-flex items-center group px-4 py-2 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-all duration-200">
    <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
    </svg>
    Back 
</a>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Item Name</label>
                        <input type="text" name="item_name" value="{{ old('item_name') }}" class="w-full border-gray-300 rounded-md shadow-sm" required placeholder="e.g. Blue Wallet">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Did you lose or find it?</label>
                        <select name="type" class="w-full border-gray-300 rounded-md shadow-sm">
                            <option value="lost" {{ old('type') == 'lost' ? 'selected' : '' }}>I Lost This</option>
                            <option value="found" {{ old('type') == 'found' ? 'selected' : '' }}>I Found This</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Category</label>
                        <select name="category" class="w-full border-gray-300 rounded-md shadow-sm">
                            <option value="Electronics">Electronics</option>
                            <option value="Documents">Documents/Wallets</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Description</label>
                        <textarea name="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Describe the item (color, brand, etc.)">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Photo</label>
                        <input type="file" name="image" class="w-full" accept="image/*">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Location</label>
                        <input type="text" name="location" value="{{ old('location') }}" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="e.g. School Library">
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                            Submit Report
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection