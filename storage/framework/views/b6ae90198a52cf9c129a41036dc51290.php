<?php $__env->startSection('header'); ?>
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-extrabold text-2xl text-slate-800 dark:text-white leading-tight">
                    <?php echo e(__('Claim Requests')); ?>

                </h2>
                <p class="text-sm text-slate-500 mt-1 italic">Review and verify ownership claims</p>
            </div>
            <div class="flex items-center space-x-2 bg-indigo-50 dark:bg-indigo-900/30 px-4 py-2 rounded-2xl border border-indigo-100 dark:border-indigo-800">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                </span>
                <span class="text-xs font-bold text-indigo-700 dark:text-indigo-300 tracking-wide uppercase">
                    <?php echo e($claims->count()); ?> Pending Review
                </span>
            </div>
        </div>
    <?php $__env->stopSection(); ?>
  <?php $__env->startSection('content'); ?>
    <div class="py-8 bg-slate-200 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <?php if(session('success')): ?>
                <div class="mb-6 flex items-center p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 rounded-2xl shadow-sm animate-fade-in-down">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span class="text-sm font-bold"><?php echo e(session('success')); ?></span>
                </div>
            <?php endif; ?>

            <div class="bg-white dark:bg-gray-800 rounded-[2rem] shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[800px]">
                        <thead>
                            <tr class="bg-slate-50/50 dark:bg-gray-700/50 border-b border-slate-100 dark:border-gray-700">
                                <th class="p-6 text-[11px] font-black uppercase text-slate-400 tracking-[0.1em]">Item Details</th>
                                <th class="p-6 text-[11px] font-black uppercase text-slate-400 tracking-[0.1em]">Claimant Info</th>
                                <th class="p-6 text-[11px] font-black uppercase text-slate-400 tracking-[0.1em] text-center">Date Submitted</th>
                                <th class="p-6 text-[11px] font-black uppercase text-slate-400 tracking-[0.1em] text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 dark:divide-gray-700">
                            <?php $__empty_1 = true; $__currentLoopData = $claims; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $claim): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-slate-50/80 dark:hover:bg-gray-700/30 transition duration-150 group">
                                    <td class="p-6">
                                        <div class="flex items-center">
                                            <div class="relative w-12 h-12 shrink-0">
                                                <?php if($claim->item->image_path): ?>
                                                    <img src="<?php echo e(asset('storage/' . $claim->item->image_path)); ?>" class="w-full h-full rounded-xl object-cover ring-2 ring-slate-100 dark:ring-gray-700">
                                                <?php else: ?>
                                                    <div class="w-full h-full rounded-xl bg-slate-100 dark:bg-gray-700 flex items-center justify-center border border-dashed border-slate-300">
                                                        <i class="fas fa-box text-slate-300"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="ml-4">
                                                <div class="font-bold text-slate-900 dark:text-white leading-tight group-hover:text-indigo-600 transition-colors"><?php echo e($claim->item->item_name); ?></div>
                                                <div class="flex items-center text-[11px] text-slate-500 mt-1">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                                    <?php echo e($claim->item->location); ?>

                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="p-6">
                                        <div class="text-sm font-bold text-slate-800 dark:text-slate-200"><?php echo e($claim->user->first_name); ?> <?php echo e($claim->user->last_name); ?></div>
                                        <div class="text-[11px] text-slate-500 font-medium flex items-center mt-0.5">
                                            <svg class="w-3 h-3 mr-1 opacity-60" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
                                            <?php echo e($claim->user->email); ?>

                                        </div>
                                    </td>

                                    <td class="p-6 text-center">
                                        <div class="text-sm font-bold text-slate-700 dark:text-slate-300"><?php echo e($claim->created_at->format('M d, Y')); ?></div>
                                        <div class="text-[10px] text-slate-400 font-medium"><?php echo e($claim->created_at->diffForHumans()); ?></div>
                                    </td>

                                    <td class="p-6 text-right">
                                        <div class="flex justify-end items-center gap-2">
                                            <?php if($claim->status === 'pending'): ?>
                                                <form id="approve-form-<?php echo e($claim->id); ?>" action="<?php echo e(route('admin.claims.update', $claim)); ?>" method="POST" class="inline">
                                                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                                    <input type="hidden" name="status" value="approved">
                                                    <input type="hidden" name="is_resolved" value="1">
                                                    <button type="button" 
                                                        onclick="openConfirmModal('approve-form-<?php echo e($claim->id); ?>', 'approve')"
                                                        class="h-9 px-4 bg-emerald-600 text-white text-xs font-bold rounded-xl shadow-lg shadow-emerald-100 dark:shadow-none hover:bg-emerald-700 transition active:scale-95">
                                                        Approve
                                                    </button>
                                                </form>

                                                <form id="reject-form-<?php echo e($claim->id); ?>" action="<?php echo e(route('admin.claims.update', $claim)); ?>" method="POST" class="inline">
                                                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                                    <input type="hidden" name="status" value="rejected">
                                                     <input type="hidden" name="is_resolved" value="0">
                                                    <button type="button" 
                                                        onclick="openConfirmModal('reject-form-<?php echo e($claim->id); ?>', 'reject')"
                                                        class="h-9 px-4 bg-white dark:bg-gray-700 border border-slate-200 dark:border-gray-600 text-rose-600 dark:text-rose-400 text-xs font-bold rounded-xl hover:bg-rose-50 dark:hover:bg-rose-900/20 transition active:scale-95">
                                                        Reject
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <span class="px-3 py-1 bg-slate-100 dark:bg-gray-700 text-slate-400 dark:text-slate-500 text-[10px] font-black uppercase tracking-widest rounded-lg">
                                                    Archived
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-16 h-16 bg-slate-50 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                                <i class="fas fa-inbox text-slate-300 text-2xl"></i>
                                            </div>
                                            <p class="text-slate-500 dark:text-slate-400 font-bold">All clear! No pending claims.</p>
                                        </div>
                                    </td>
                                <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="confirmationModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>

        <div class="flex min-h-screen items-end sm:items-center justify-center p-0 sm:p-4 text-center">
            <div class="relative transform overflow-hidden rounded-t-[2.5rem] sm:rounded-[2rem] bg-white dark:bg-gray-800 text-left shadow-2xl transition-all w-full sm:max-w-lg animate-fade-in-up">
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
                    <button type="button" onclick="closeModal()" class="w-full sm:flex-1 py-4 px-6 rounded-2xl bg-slate-100 dark:bg-gray-700 text-slate-600 dark:text-slate-300 font-bold text-sm hover:bg-slate-200 transition">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
   <script>
    // 1. Initialize the global tracker
    let activeFormId = null;

    function openConfirmModal(formId, type) {
        // 2. CRITICAL: Assign the passed formId so the Confirm button knows what to submit
        activeFormId = formId; 

        const modal = document.getElementById('confirmationModal');
        const title = document.getElementById('modal-title');
        const desc = document.getElementById('modalDescription');
        const iconContainer = document.getElementById('modalIconContainer');
        const icon = document.getElementById('modalIcon');
        const confirmBtn = document.getElementById('confirmBtn');

        // Reset Tailwind classes to prevent color bleeding between Approve/Reject
        confirmBtn.classList.remove('bg-emerald-600', 'hover:bg-emerald-700', 'bg-rose-600', 'hover:bg-rose-700');
        iconContainer.classList.remove('bg-emerald-100', 'bg-rose-100');

        if (type === 'approve') {
            title.innerText = 'Approve This Claim?';
            desc.innerText = 'By approving, this item will be marked as resolved. All other pending claims for this item will be automatically rejected.';
            iconContainer.classList.add('bg-emerald-100');
            icon.className = 'fas fa-check-circle text-emerald-600 text-2xl';
            confirmBtn.classList.add('bg-emerald-600', 'hover:bg-emerald-700');
        } else {
            title.innerText = 'Reject This Claim?';
            desc.innerText = 'Are you sure you want to reject this request? This user will be notified that their claim was unsuccessful.';
            iconContainer.classList.add('bg-rose-100');
            icon.className = 'fas fa-exclamation-triangle text-rose-600 text-2xl';
            confirmBtn.classList.add('bg-rose-600', 'hover:bg-rose-700');
        }

        // Show the modal
        modal.classList.remove('hidden');

        // 3. Handle the confirmation click
        confirmBtn.onclick = function(e) {
            e.preventDefault();
            
            if (activeFormId) {
                const form = document.getElementById(activeFormId);
                if (form) {
                    // Visual feedback
                    confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
                    confirmBtn.disabled = true;
                    
                    // Trigger the Laravel form (this sends the POST + _method PATCH)
                    form.submit();
                }
            }
        };
    }

    // 4. Function to hide the modal
    function closeModal() {
        document.getElementById('confirmationModal').classList.add('hidden');
        activeFormId = null;
    }

    // Optional: Close modal if user presses "Esc" key
    window.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeModal();
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/riku/Documents/laravel_poject/lost_n_found/resources/views/admin/claims/index.blade.php ENDPATH**/ ?>