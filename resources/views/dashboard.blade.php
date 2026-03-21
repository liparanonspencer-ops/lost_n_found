<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8 flex space-x-4">
                <a href="{{ route('items.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold shadow hover:bg-blue-700 transition">
                    + Report Lost/Found Item
                </a>
                <a href="{{ route('items.index') }}" class="bg-white border border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-bold shadow hover:bg-gray-50 transition">
                    View All Items
                </a>
        </div>
            <div class="bg-gray-200 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">Recent Reports</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse($items as $item)
                        <div class="border rounded-lg overflow-hidden flex flex-col bg-gray-50 dark:bg-gray-700">
                            <div class="h-32 bg-gray-200">
                                @if($item->image_path)
                                    <img src="{{ asset('storage/' . $item->image_path) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-400 text-xs">No Image</div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h4 class="font-bold text-sm truncate">{{ $item->item_name }}</h4>
                                <p class="text-xs text-gray-500 mt-1">{{ $item->location }}</p>
                                <div class="mt-3 flex justify-between items-center">
                                    <span class="text-[10px] font-bold uppercase px-2 py-1 rounded {{ $item->type == 'lost' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                        {{ $item->type }}
                                    </span>
                                    <a href="{{ route('items.show', $item->id) }}" class="text-blue-600 text-xs font-bold hover:underline">View →</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 col-span-3 text-center py-10">No items reported yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>