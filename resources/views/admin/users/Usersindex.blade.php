<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-extrabold text-2xl text-slate-800 dark:text-white leading-tight">
                    {{ __("Manage User Accounts") }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 italic">Update or remove registered user accounts</p>
            </div>
            <div class="flex items-center space-x-2 bg-indigo-50 dark:bg-indigo-900/30 px-4 py-2 rounded-2xl border border-indigo-100 dark:border-indigo-800">
                <span class="text-xs font-bold text-indigo-700 dark:text-indigo-300 tracking-wide uppercase">
                    {{ $users->count() }} Total Users
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 flex items-center p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 rounded-2xl shadow-sm animate-fade-in-down">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span class="text-sm font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 rounded-[2rem] shadow-xl border border-slate-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[800px]">
                        <thead>
                            <tr class="bg-slate-50/50 dark:bg-gray-700/50 border-b border-slate-100 dark:border-gray-700">
                                <th class="p-6 text-[11px] font-black uppercase text-slate-400 tracking-[0.1em]">User Info</th>
                                <th class="p-6 text-[11px] font-black uppercase text-slate-400 tracking-[0.1em] text-center">Address</th>
                                <th class="p-6 text-[11px] font-black uppercase text-slate-400 tracking-[0.1em] text-center">Joined</th>
                                <th class="p-6 text-[11px] font-black uppercase text-slate-400 tracking-[0.1em] text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 dark:divide-gray-700">
                            @forelse($users as $user)
                                <tr class="hover:bg-slate-50/80 dark:hover:bg-gray-700/30 transition duration-150">
                                    <td class="p-6">
                                        <div class="text-sm font-bold text-slate-800 dark:text-slate-200">{{ $user->first_name }} {{ $user->last_name }}</div>
                                        <div class="text-[11px] text-slate-500 font-medium flex items-center mt-0.5">
                                            {{ $user->email }}
                                        </div>
                                    </td>
                                    <td class="p-6 text-center text-sm text-slate-600 dark:text-slate-400">
                                        {{ $user->address ?? 'N/A' }}
                                    </td>
                                    <td class="p-6 text-center">
                                        <div class="text-sm font-bold text-slate-700 dark:text-slate-300">{{ $user->created_at->format('M d, Y') }}</div>
                                    </td>
                                    <td class="p-6 text-right">
                                        <div class="flex justify-end items-center gap-2">
                                            <button onclick="openEditModal({{ $user->toJson() }})" 
                                                class="px-3 py-1 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-lg font-black text-[10px] uppercase hover:bg-indigo-600 hover:text-white transition">
                                                Edit
                                            </button>

                                            <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="openConfirmModal('delete-form-{{ $user->id }}', 'delete')" 
                                                    class="px-3 py-1 bg-rose-50 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 rounded-lg font-black text-[10px] uppercase hover:bg-rose-600 hover:text-white transition">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-20 text-center text-slate-500 font-bold">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="confirmationModal" class="fixed inset-0 z-[60] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeModal('confirmationModal')"></div>
        <div class="flex min-h-screen items-center justify-center p-4 text-center">
            <div class="relative transform overflow-hidden rounded-[2rem] bg-white dark:bg-gray-800 text-left shadow-2xl transition-all w-full max-w-lg">
                <div class="p-8">
                    <div class="flex flex-col items-center text-center">
                        <div id="modalIconContainer" class="flex h-20 w-20 items-center justify-center rounded-3xl mb-6">
                            <i id="modalIcon" class="fas text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 dark:text-white" id="modal-title">Confirm Action</h3>
                        <p class="mt-4 text-slate-500 dark:text-slate-400 leading-relaxed text-sm" id="modalDescription"></p>
                    </div>
                </div>
                <div class="p-8 pt-0 flex flex-col sm:flex-row-reverse gap-3">
                    <button type="button" id="confirmBtn" class="w-full sm:flex-1 py-4 px-6 rounded-2xl text-white font-bold text-sm shadow-xl transition active:scale-95">
                        Confirm
                    </button>
                    <button type="button" onclick="closeModal('confirmationModal')" class="w-full sm:flex-1 py-4 px-6 rounded-2xl bg-slate-100 dark:bg-gray-700 text-slate-600 dark:text-slate-300 font-bold text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="editModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 p-8 rounded-[2.5rem] shadow-2xl w-full max-w-md border border-slate-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-black text-slate-800 dark:text-white">Edit User Profile</h3>
                <button onclick="closeModal('editModal')" class="text-slate-400 hover:text-slate-600 transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="editForm" method="POST">
                @csrf
                @method('PUT') 
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">First Name</label>
                            <input type="text" name="first_name" id="edit_first_name" class="w-full rounded-2xl border-none bg-slate-50 dark:bg-gray-900 focus:ring-2 focus:ring-indigo-500 dark:text-white font-semibold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Last Name</label>
                            <input type="text" name="last_name" id="edit_last_name" class="w-full rounded-2xl border-none bg-slate-50 dark:bg-gray-900 focus:ring-2 focus:ring-indigo-500 dark:text-white font-semibold">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Home Address</label>
                        <input type="text" name="address" id="edit_address" class="w-full rounded-2xl border-none bg-slate-50 dark:bg-gray-900 focus:ring-2 focus:ring-indigo-500 dark:text-white font-semibold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Email Address</label>
                        <input type="email" name="email" id="edit_email" class="w-full rounded-2xl border-none bg-slate-50 dark:bg-gray-900 focus:ring-2 focus:ring-indigo-500 dark:text-white font-semibold">
                    </div>
                </div>

                <div class="mt-8 flex gap-3">
                    <button type="button" onclick="closeModal('editModal')" class="flex-1 px-6 py-4 bg-slate-50 dark:bg-gray-700 text-slate-600 dark:text-slate-300 rounded-2xl font-bold transition hover:bg-slate-100">Cancel</button>
                    <button type="submit" class="flex-1 px-6 py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 dark:shadow-none hover:bg-indigo-700 transition active:scale-95">Save Changes</button>
                </div>
            </form>
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

            if (type === 'delete') {
                title.innerText = 'Delete User Account?';
                desc.innerText = 'This action is permanent. All user data will be removed from the system immediately. You cannot undo this.';
                iconContainer.className = 'flex h-20 w-20 items-center justify-center rounded-3xl mb-6 bg-rose-100 dark:bg-rose-900/30';
                icon.className = 'fas fa-trash-alt text-rose-600';
                confirmBtn.className = 'w-full sm:flex-1 py-4 px-6 rounded-2xl bg-rose-600 text-white font-bold text-sm shadow-xl shadow-rose-100 dark:shadow-none hover:bg-rose-700 transition';
            }

            modal.classList.remove('hidden');
            confirmBtn.onclick = function() {
                confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
                document.getElementById(activeFormId).submit();
            };
        }

        function openEditModal(user) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');
            
            form.action = '/admin/users/' + user.id; 

            document.getElementById('edit_first_name').value = user.first_name || '';
            document.getElementById('edit_last_name').value = user.last_name || '';
            document.getElementById('edit_address').value = user.address || '';
            document.getElementById('edit_email').value = user.email || '';

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.style.overflow = 'auto';
            activeFormId = null;
        }
    </script>
</x-app-layout>