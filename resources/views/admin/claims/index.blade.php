<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin: Manage Claim Requests') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                <div class="mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Pending Requests</h3>
                    <p class="text-sm text-gray-500">Review and approve or reject item claims below.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="p-4 text-xs font-semibold uppercase text-gray-600 tracking-wider">Item Details</th>
                                <th class="p-4 text-xs font-semibold uppercase text-gray-600 tracking-wider">Claimant</th>
                                <th class="p-4 text-xs font-semibold uppercase text-gray-600 tracking-wider">Date Submitted</th>
                                <th class="p-4 text-xs font-semibold uppercase text-gray-600 tracking-wider text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($claims as $claim)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-4">
                                        <div class="font-bold text-gray-800">{{ $claim->item->item_name }}</div>
                                        <div class="flex items-center text-xs text-gray-500 mt-1">
                                            <i class="fas fa-map-marker-alt mr-1"></i> {{ $claim->item->location }}
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $claim->user->name }}</div>
                                        <div class="text-xs text-gray-400">{{ $claim->user->email }}</div>
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">
                                        {{ $claim->created_at->format('M d, Y') }}
                                        <span class="block text-[10px] text-gray-400">{{ $claim->created_at->diffForHumans() }}</span>
                                    </td>
                                    <td class="p-4 text-right space-x-2 whitespace-nowrap">
                                        <form action="{{ route('admin.claims.update', $claim) }}" method="POST" class="inline">
                                            @csrf 
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="inline-flex items-center bg-green-600 text-white px-4 py-2 rounded-md text-xs font-bold hover:bg-green-700 transition shadow-sm">
                                                <i class="fas fa-check mr-1"></i> Approve
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.claims.update', $claim) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to reject this claim?');">
                                            @csrf 
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="inline-flex items-center bg-white border border-red-200 text-red-600 px-4 py-2 rounded-md text-xs font-bold hover:bg-red-50 transition">
                                                <i class="fas fa-times mr-1"></i> Reject
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-clipboard-check text-gray-200 text-5xl mb-3"></i>
                                            <p class="text-gray-500 italic">No pending claim requests found.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if(isset($history) && $history->count() > 0)
                <div class="mt-8 bg-gray-50 p-6 rounded-lg border border-gray-200 shadow-sm">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-history text-gray-400 mr-2"></i>
                        <h3 class="text-md font-bold text-gray-700 uppercase tracking-tight">Recent Activity History</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead>
                                <tr class="text-gray-400 border-b border-gray-200">
                                    <th class="pb-2 font-medium">Item</th>
                                    <th class="pb-2 font-medium">User</th>
                                    <th class="pb-2 font-medium text-right">Result</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($history as $h)
                                    <tr>
                                        <td class="py-3 font-medium text-gray-700">{{ $h->item->item_name }}</td>
                                        <td class="py-3 text-gray-500">{{ $h->user->name }}</td>
                                        <td class="py-3 text-right">
                                            <span class="px-2 py-1 rounded text-[10px] font-bold uppercase {{ $h->status == 'approved' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $h->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>