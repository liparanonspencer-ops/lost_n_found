<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lost & Found Items') }}
        </h2>
    </x-slot>

    @forelse($items as $item)
    <p>{{ $item->title }}</p>
   @empty
    <p>No items found.</p>
   @endforelse

    <div class="container mx-auto p-6">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold">Latest Reports</h1>
            
            <div class="flex gap-4">
                <form action="{{ route('items.index') }}" method="GET" class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search items..." class="border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Search</button>
                </form>
                <a href="{{ route('items.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    + Report Item
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($items as $item)
                <div class="bg-gradient-to-r from-blue-500 to-cyan-400 p-[1px] sm:rounded-lg shadow-sm overflow-hidden flex flex-col">
                    <div class="bg-white p-6 sm:rounded-[calc(0.5rem-1px)]">
                    <div class="h-48 bg-gray-100 flex items-center justify-center">
                        @if($item->image_path)
                            <img src="/storage/{{ $item->image_path }}" class="w-full h-full object-cover">
                        @else
                            <div class="text-center">
                                <span class="text-white block text-sm italic">No Image</span>
                            </div>
                        @endif
                    </div>
                    </div>

                    <div class="p-4 flex-grow flex flex-col">
                        <div class="flex justify-between items-start mb-2">
                            <h2 class="font-semibold text-lg truncate flex-1 mr-2">{{ $item->item_name }}</h2>
                            <span class="text-[10px] font-bold uppercase px-2 py-1 rounded {{ $item->type == 'lost' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                {{ $item->type }}
                            </span>
                        </div>
                        
                        <p class="text-white text-sm"><i class="fas fa-tag"></i> {{ $item->category }}</p>
                        <p class="text-white text-sm mt-1"><i class="fas fa-map-marker-alt"></i> {{ $item->location }}</p>
                        <p class="text-white text-[10px] mt-auto pt-4">{{ $item->created_at->diffForHumans() }}</p>
                        
                        <a href="{{ route('items.show', $item->id) }}" class="mt-4 block text-center bg-gray-800 text-white py-2 rounded hover:bg-gray-700 transition">
                            View Details
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center bg-gray-50 rounded-lg border-2 border-dashed">
                    <p class="text-gray-500">No items found matching your criteria.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $items->appends(request()->query())->links() }}
        </div>
    </div>
</div>
</x-app-layout>