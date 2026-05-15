<?php $__env->startSection('header'); ?>
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 px-2 sm:px-0">
        <div class="text-left">
            <h2 class="font-extrabold text-2xl md:text-3xl text-slate-800 dark:text-white leading-tight">
                <?php echo e(__('Notifications')); ?>

            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Stay updated on your item claims and reports</p>
        </div>

        <?php if($unreadCount > 0): ?>
            <form action="<?php echo e(route('notifications.markAllRead')); ?>" method="POST" class="w-full sm:w-auto">
                <?php echo csrf_field(); ?>
                <button type="submit" class="w-full sm:w-auto flex items-center justify-center text-xs font-black text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 uppercase tracking-widest bg-indigo-50 dark:bg-indigo-900/30 px-6 py-3 rounded-2xl transition-all active:scale-95 border border-indigo-100 dark:border-indigo-800/50 shadow-sm">
                    <i class="fas fa-check-double mr-2"></i><?php echo e(__('Mark All as Read')); ?>

                </button>
            </form>
        <?php endif; ?>

         <?php if($unreadCount > 0): ?>
            <form action="<?php echo e(route('notifications.destroyAll')); ?>" method="POST" class="w-full sm:w-auto">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="w-full sm:w-auto flex items-center justify-center text-xs font-black text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 uppercase tracking-widest bg-indigo-50 dark:bg-indigo-900/30 px-6 py-3 rounded-2xl transition-all active:scale-95 border border-indigo-100 dark:border-indigo-800/50 shadow-sm">
                   <i class="fas fa-trash text-red-500"></i>
                        <?php echo e(__('Delete All')); ?>

             </button>
            </form>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="py-6 md:py-10 bg-slate-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        
        <div class="bg-white dark:bg-gray-800 rounded-[1.5rem] md:rounded-[2.5rem] shadow-xl shadow-slate-200/60 dark:shadow-none border border-slate-100 dark:border-gray-700 overflow-hidden">
            
            
            <div class="px-6 md:px-10 py-5 border-b border-slate-50 dark:border-gray-700 flex items-center justify-between bg-slate-50/50 dark:bg-gray-700/30">
                <div class="flex items-center space-x-3">
                    <div class="h-10 w-10 rounded-xl bg-indigo-500 flex items-center justify-center text-white shadow-lg shadow-indigo-200 dark:shadow-none">
                        <i class="fas fa-bell text-sm"></i>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-widest">Inbox</span>
                    </div>
                </div>
            </div>

            
            <div class="divide-y divide-slate-50 dark:divide-gray-700">
                <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="transition-colors hover:bg-slate-50/50 dark:hover:bg-gray-700/20">
                        <?php echo $__env->make('notifications.partials.notification_item', ['notification' => $notification], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="py-20 md:py-32 text-center px-6">
                        <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-slate-100 dark:bg-gray-700 text-slate-300 dark:text-gray-500 mb-6">
                            <i class="fas fa-bell-slash text-4xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white"><?php echo e(__('All caught up!')); ?></h3>
                        <p class="text-slate-500 dark:text-slate-400 mt-2 max-w-xs mx-auto leading-relaxed">
                            <?php echo e(__('Your inbox is clear. We will notify you when there is an update on your items.')); ?>

                        </p>
                    </div>
                <?php endif; ?>
            </div>

            
            <?php if($notifications->hasPages()): ?>
                <div class="px-6 md:px-10 py-6 bg-slate-50/30 dark:bg-gray-700/10 border-t border-slate-50 dark:border-gray-700">
                    <?php echo e($notifications->links()); ?>

                </div>
            <?php endif; ?>
        </div>

        
        <div class="mt-8 text-center">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">
                STI &bull; Lost & Found System
            </p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/riku/Documents/laravel_poject/lost_n_found/resources/views/notifications/index.blade.php ENDPATH**/ ?>