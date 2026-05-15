<?php $__env->startSection('header'); ?>
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 px-4">
        <h2 class="font-bold text-xl sm:text-2xl text-slate-800 dark:text-slate-100 leading-tight">
            <?php echo e(__('Item Details')); ?>

        </h2>
        <a href="<?php echo e(route('items.index')); ?>" 
           class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-indigo-600 transition-colors group">
            <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to List
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="py-6 sm:py-10 bg-slate-200 dark:bg-gray-900 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <?php if(session('success')): ?>
            <div class="mb-6 flex items-center p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl shadow-sm">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm font-bold"><?php echo e(session('success')); ?></p>
            </div>
        <?php endif; ?>

        <div class="bg-white dark:bg-gray-800 rounded-[1.5rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/60 dark:shadow-none overflow-hidden border border-slate-100 dark:border-gray-700">
            <div class="flex flex-col lg:flex-row">
                
                
                <div class="lg:w-1/2 bg-slate-100 dark:bg-gray-900 flex items-center justify-center relative h-[300px] sm:h-[400px] lg:h-auto">
                    <?php if($item->image_path): ?>
                        <img src="<?php echo e(asset('storage/' . $item->image_path)); ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="flex flex-col items-center text-slate-400">
                            <svg class="w-16 h-16 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="font-medium italic">No Image Available</span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="absolute top-4 left-4 sm:top-6 sm:left-6">
                        <span class="px-3 py-1 sm:px-4 sm:py-1.5 text-[10px] sm:text-xs font-black uppercase tracking-widest rounded-full shadow-lg <?php echo e($item->type == 'lost' ? 'bg-rose-500 text-white' : 'bg-emerald-500 text-white'); ?>">
                            <?php echo e($item->type); ?>

                        </span>
                    </div>
                </div>

                
                <div class="lg:w-1/2 p-6 sm:p-8 lg:p-12">
                    <div class="mb-6">
                        <p class="text-indigo-600 dark:text-indigo-400 font-black text-[10px] sm:text-xs uppercase tracking-[0.2em] mb-2"><?php echo e($item->category); ?></p>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white leading-tight"><?php echo e($item->item_name); ?></h1>
                    </div>

                    <div class="grid grid-cols-2 gap-4 sm:gap-6 mb-8">
                        <div class="col-span-2">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Description</h3>
                                <span class="relative inline-flex items-center px-3 py-1 text-[10px] sm:text-[12px] font-black uppercase tracking-tighter rounded-full shadow-sm border <?php echo e($item->status == 'available' ? 'bg-emerald-500 text-white border-emerald-700' : 'bg-rose-500 text-white border-rose-700'); ?>">
                                    <?php if($item->status == 'available'): ?>
                                        <span class="animate-ping absolute inset-0 rounded-full bg-emerald-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-1.5 w-1.5 sm:h-2 sm:w-2 bg-white mr-2"></span>
                                    <?php else: ?>
                                        <span class="relative inline-flex rounded-full h-1.5 w-1.5 sm:h-2 sm:w-2 bg-rose-200 mr-2"></span>
                                    <?php endif; ?>
                                    <span class="relative"><?php echo e($item->status); ?></span>
                                </span>
                            </div>
                            <p class="text-slate-600 dark:text-slate-300 leading-relaxed text-sm sm:text-base">
                                <?php echo e($item->description); ?>

                            </p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700/50 p-4 rounded-2xl">
                            <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Location</h3>
                            <p class="text-sm font-bold text-slate-700 dark:text-slate-200 truncate"><?php echo e($item->location); ?></p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700/50 p-4 rounded-2xl">
                            <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Posted On</h3>
                            <p class="text-sm font-bold text-slate-700 dark:text-slate-200"><?php echo e($item->created_at->format('M d, Y')); ?></p>
                        </div>

                        <?php if($item->user && $item->user->show_phone_publicly && $item->user->phone_number): ?>
                            <div class="col-span-2 mt-2 bg-indigo-50 dark:bg-indigo-900/30 p-4 rounded-2xl border border-indigo-100 dark:border-indigo-800/50">
                                <h3 class="text-[10px] font-bold text-indigo-400 dark:text-indigo-300 uppercase tracking-widest mb-1">Contact Number</h3>
                                <p class="text-sm font-extrabold text-indigo-700 dark:text-indigo-200 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <?php echo e($item->user->phone_number); ?>

                                </p>
                            </div>
                        <?php endif; ?>
                    </div>

                    
                    <div class="mt-8 pt-8 border-t border-slate-100 dark:border-gray-700">
                        <?php if(auth()->id() !== $item->user_id): ?>
                            <?php
                                $userClaim = \App\Models\Claim::where('item_id', $item->id)->where('user_id', auth()->id())->first();
                            ?>

                            <?php if(!$userClaim): ?>
                                <form action="<?php echo e(route('claims.store')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="item_id" value="<?php echo e($item->id); ?>">
                                    <button type="submit" class="w-full py-4 rounded-2xl shadow-lg text-white font-bold transition-transform hover:scale-[1.02] active:scale-[0.98]" style="background: #5b4ef3;">
                                        This is Mine / I Found This
                                    </button>
                                </form>
                                <p class="text-[10px] text-center text-slate-400 mt-3 uppercase tracking-widest font-bold">Verification will be required</p>

                            <?php elseif($userClaim->status === 'approved'): ?>
                                <div class="bg-emerald-50 dark:bg-emerald-900/20 p-6 rounded-[2rem] border border-emerald-100 dark:border-emerald-800 text-center">
                                    <div class="flex items-center justify-center text-emerald-600 dark:text-emerald-400 mb-4">
                                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        <span class="font-black uppercase tracking-wider">Claim Approved!</span>
                                    </div>

                                    <p class="text-xs text-emerald-700 dark:text-emerald-300 font-medium leading-relaxed mb-6">
                                        Your claim is verified. To prevent system abuse, you must view a short advertisement before printing your pass.
                                    </p>

                                    
                                    <a href="<?php echo e(route('claims.ads', $userClaim->id)); ?>" 
                                       class="inline-flex items-center justify-center w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl font-bold shadow-lg transition-all hover:scale-[1.02]">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                        </svg>
                                        View & Print Retrieval Pass
                                    </a>
                                </div>

                            <?php elseif($userClaim->status === 'rejected'): ?>
                                <div class="bg-rose-50 p-5 rounded-2xl border border-rose-100 text-rose-700 text-center">
                                    <p class="font-black uppercase text-xs tracking-widest">Claim Not Approved</p>
                                </div>
                            <?php else: ?>
                                <div class="bg-amber-50 p-6 rounded-2xl border border-amber-100 text-amber-800 text-center">
                                    <div class="flex items-center justify-center mb-1">
                                        <svg class="w-5 h-5 mr-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <p class="font-black uppercase text-xs tracking-widest">Claim Pending Review</p>
                                    </div>
                                    <p class="text-xs text-amber-700">The admin is checking your claim.</p>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="bg-indigo-50 dark:bg-indigo-900/20 p-5 rounded-2xl border border-indigo-100 dark:border-indigo-800 text-indigo-800 dark:text-indigo-300 text-sm text-center font-bold">
                                You posted this report.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/riku/Documents/laravel_poject/lost_n_found/resources/views/items/show.blade.php ENDPATH**/ ?>