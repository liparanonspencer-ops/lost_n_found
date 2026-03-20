<x-app-layout>
    <x-slot name="header" class="border-l-4 border-blue-500">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Claim Requests') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-gradient-to-r from-blue-500 to-cyan-400 p-[1px] sm:rounded-lg shadow-sm overflow-hidden">
                <div class="bg-white p-6 sm:rounded-[calc(0.5rem-1px)]">
                    <div class="mb-6 flex justify-between items-end">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Pending Requests</h3>
                            <p class="text-sm text-gray-500">Review and verify claims. Approving one will close all other requests for that item.</p>
                        </div>
                        <span class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full">
                            {{ $claims->count() }} Total Pending
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b">
                                    <th class="p-4 text-xs font-semibold uppercase text-gray-600 tracking-wider">Item Details</th>
                                    <th class="p-4 text-xs font-semibold uppercase text-gray-600 tracking-wider">Claimant</th>
                                    <th class="p-4 text-xs font-semibold uppercase text-gray-600 tracking-wider text-center">Submitted</th>
                                    <th class="p-4 text-xs font-semibold uppercase text-gray-600 tracking-wider text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($claims as $claim)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="p-4">
                                            <div class="flex items-center">
                                                @if($claim->item->image_path)
                                                    <img src="{{ asset('storage/' . $claim->item->image_path) }}" class="w-10 h-10 rounded-md object-cover mr-3 border border-gray-200 shadow-sm">
                                                @else
                                                    <div class="w-10 h-10 rounded-md bg-gray-100 flex items-center justify-center mr-3 border border-dashed border-gray-300">
                                                        <i class="fas fa-box text-gray-300 text-xs"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="font-bold text-gray-800 leading-tight">{{ $claim->item->item_name }}</div>
                                                    <div class="flex items-center text-[10px] text-gray-500 mt-1">
                                                        <i class="fas fa-map-marker-alt mr-1 text-blue-400"></i> {{ $claim->item->location }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="p-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $claim->user->first_name }} {{ $claim->user->last_name }}</div>
                                            <div class="text-[10px] text-gray-500 italic">{{ $claim->user->email }}</div>
                                            <div class="text-[10px] text-gray-400 font-mono">{{ $claim->user->address }}</div>
                                        </td>

                                        <td class="p-4 text-center">
                                            <div class="text-sm text-gray-600 font-medium">{{ $claim->created_at->format('M d, Y') }}</div>
                                            <div class="text-[10px] text-gray-400">{{ $claim->created_at->diffForHumans() }}</div>
                                        </td>

                                        <td class="p-4 text-right space-x-1 whitespace-nowrap">
                                            @if($claim->status === 'pending')
                                                <form id="approve-form-{{ $claim->id }}" action="{{ route('admin.claims.update', $claim) }}" method="POST" class="inline">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="button" 
                                                        onclick="openConfirmModal('approve-form-{{ $claim->id }}', 'approve')"
                                                        class="inline-flex items-center bg-green-600 text-white px-3 py-1.5 rounded text-xs font-bold hover:bg-green-700 transition shadow-sm">
                                                        <i class="fas fa-check mr-1.5"></i> Approve
                                                    </button>
                                                </form>

                                                <form id="reject-form-{{ $claim->id }}" action="{{ route('admin.claims.update', $claim) }}" method="POST" class="inline">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="button" 
                                                        onclick="openConfirmModal('reject-form-{{ $claim->id }}', 'reject')"
                                                        class="inline-flex items-center bg-white border border-red-200 text-red-600 px-3 py-1.5 rounded text-xs font-bold hover:bg-red-50 transition">
                                                        <i class="fas fa-times mr-1.5"></i> Reject
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-[10px] font-bold uppercase px-2 py-1 rounded bg-gray-100 text-gray-400">Processed</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="confirmationModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeModal()"></div>

            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div id="modalIconContainer" class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full sm:mx-0 sm:h-10 sm:w-10">
                            <i id="modalIcon" class="fas"></i>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-lg font-bold leading-6 text-gray-900" id="modal-title">Confirm Action</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500" id="modalDescription"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" id="confirmBtn" class="inline-flex w-full justify-center rounded-md px-4 py-2 text-sm font-bold text-white shadow-sm sm:ml-3 sm:w-auto">
                        Confirm
                    </button>
                    <button type="button" onclick="closeModal()" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let activeFormId = null;

        function openConfirmModal(formId, type) {
            activeFormId = formId;
            const modal = document.getElementById('confirmationModal');
            const title = document.getElementById('modal-title');
            const desc = document.getElementById('modalDescription');
            const iconContainer = document.getElementById('modalIconContainer');
            const icon = document.getElementById('modalIcon');
            const confirmBtn = document.getElementById('confirmBtn');

            if (type === 'approve') {
                title.innerText = 'Approve This Claim?';
                desc.innerText = 'By approving, this item will be marked as resolved. All other pending claims for this item will be automatically rejected.';
                iconContainer.className = 'mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10';
                icon.className = 'fas fa-check-circle text-green-600';
                confirmBtn.className = 'inline-flex w-full justify-center rounded-md bg-green-600 px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-green-700 sm:ml-3 sm:w-auto';
            } else {
                title.innerText = 'Reject This Claim?';
                desc.innerText = 'Are you sure you want to reject this request? This user will be notified that their claim was unsuccessful.';
                iconContainer.className = 'mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10';
                icon.className = 'fas fa-exclamation-triangle text-red-600';
                confirmBtn.className = 'inline-flex w-full justify-center rounded-md bg-red-600 px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-red-700 sm:ml-3 sm:w-auto';
            }

            modal.classList.remove('hidden');

            confirmBtn.onclick = function() {
                // Optional: Show loading state on button
                confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
                confirmBtn.disabled = true;
                document.getElementById(activeFormId).submit();
            };
        }

        function closeModal() {
            document.getElementById('confirmationModal').classList.add('hidden');
            activeFormId = null;
        }
    </script>
</x-app-layout>