<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Item Details: {{ $item->item_name }}
            </h2>
            <a href="{{ route('items.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                &larr; Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="md:flex">
                    <div class="md:w-1/2 bg-gray-100 flex items-center justify-center p-4">
                        @if($item->image_path)
                            <img src="{{ asset('storage/' . $item->image_path) }}" class="rounded-lg shadow-sm max-h-96 object-contain">
                        @else
                            <div class="text-center py-20">
                                <i class="fas fa-image text-gray-300 text-5xl mb-2"></i>
                                <p class="text-gray-400 italic">No image available</p>
                            </div>
                        @endif
                    </div>

                    <div class="md:w-1/2 p-8">
                        <div class="mb-4">
                            <span class="text-xs font-bold uppercase px-2 py-1 rounded {{ $item->type == 'lost' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                {{ strtoupper($item->type) }}
                            </span>
                            <span class="ml-2 text-sm text-gray-500">{{ $item->category }}</span>
                        </div>

                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $item->item_name }}</h1>
                        
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Description</h3>
                                <p class="mt-1 text-gray-700 leading-relaxed">{{ $item->description }}</p>
                            </div>

                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i>
                                <span><strong>Location:</strong> {{ $item->location }}</span>
                            </div>

                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-calendar-alt mr-2 text-blue-500"></i>
                                <span><strong>Posted:</strong> {{ $item->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>

                        <div class="mt-10 pt-6 border-t border-gray-100">
                            @if(auth()->id() !== $item->user_id)
                                @php
                                    // NEW: We fetch the whole claim record instead of just checking if it exists
                                    $userClaim = \App\Models\Claim::where('item_id', $item->id)
                                                                 ->where('user_id', auth()->id())
                                                                 ->first();
                                @endphp

                                @if($userClaim)
                                    @if($userClaim->status === 'approved')
                                        <div class="bg-green-50 p-4 rounded-lg border border-green-200 text-green-800 text-center shadow-sm">
                                            <div class="flex items-center justify-center mb-1">
                                                <i class="fas fa-check-circle text-xl mr-2"></i>
                                                <span class="font-bold text-lg">Claim Approved!</span>
                                            </div>
                                            <p class="text-sm">The administrator has verified your claim. Please coordinate to retrieve your item.</p>
                                        </div>

                                    @elseif($userClaim->status === 'rejected')
                                        <div class="bg-red-50 p-4 rounded-lg border border-red-200 text-red-800 text-center">
                                            <i class="fas fa-times-circle mr-1 text-lg"></i> 
                                            <span class="font-bold">Claim Not Approved.</span>
                                            <p class="text-xs mt-1">Please contact the admin for more details.</p>
                                        </div>

                                    @else
                                        <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200 text-yellow-800 text-center">
                                            <i class="fas fa-clock mr-1"></i> Your claim is <strong>Pending</strong>.
                                            <p class="text-xs mt-1 italic">An admin will review your request soon.</p>
                                        </div>
                                    @endif
                                @else
                                    <form action="{{ route('items.claim', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-700 transition shadow-lg transform active:scale-95">
                                            <i class="fas fa-hand-paper mr-2"></i> I found this / This is mine
                                        </button>
                                        <p class="text-center text-gray-500 text-[10px] mt-3 italic">
                                            The owner will be notified of your claim.
                                        </p>
                                    </form>
                                @endif
                            @else
                                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 text-blue-800 text-sm text-center">
                                    <i class="fas fa-user-circle mr-1"></i> You posted this report. Manage claims in your dashboard.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>