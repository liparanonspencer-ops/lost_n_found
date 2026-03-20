<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Claims Archive') }}
            </h2>
            <a href="{{ route('admin.claims.index') }}" class="text-sm text-blue-600 hover:underline">
                &larr; Back to Pending
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <th class="p-4 text-xs font-bold uppercase text-gray-600">Item</th>
                            <th class="p-4 text-xs font-bold uppercase text-gray-600">Claimant</th>
                            <th class="p-4 text-xs font-bold uppercase text-gray-600">Processed Date</th>
                            <th class="p-4 text-xs font-bold uppercase text-gray-600 text-right">Final Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($claims as $claim)
                            <tr>
                                <td class="p-4">
                                    <span class="font-bold text-gray-800">{{ $claim->item->item_name }}</span>
                                    <p class="text-xs text-gray-400">{{ $claim->item->category }}</p>
                                </td>
                                <td class="p-4">
                                    <div class="text-sm">{{ $claim->user->name }}</div>
                                    <div class="text-xs text-gray-400">{{ $claim->user->email }}</div>
                                </td>
                                <td class="p-4 text-sm text-gray-500">
                                    {{ $claim->updated_at->format('M d, Y') }}
                                </td>
                                <td class="p-4 text-right">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                                        {{ $claim->status === 'approved' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $claim->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-10 text-center text-gray-400 italic">No archived records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                
                <div class="mt-4">
                    {{ $claims->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>