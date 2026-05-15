<div class="flex items-start gap-x-4 px-6 py-6 transition-colors duration-200 <?php echo e($notification->read_at ? '' : 'bg-blue-50'); ?> hover:bg-gray-50 relative group">
    
  <?php
    $type = $notification->data['type'] ?? 'system_alert';
    $icon = $notification->data['icon'] ?? 'fas fa-bell';
    $isUnread = !$notification->read_at;

    // Professional color and icon mapping for a Lost and Found System
    $styles = [
        'registration_otp' => [
            'bg' => 'bg-amber-50 dark:bg-amber-900/20', 
            'icon' => 'text-amber-600 dark:text-amber-400', 
            'fa' => 'fas fa-shield-alt'
        ],
        'claim_approved'   => [
            'bg' => 'bg-emerald-50 dark:bg-emerald-900/20', 
            'icon' => 'text-emerald-600 dark:text-emerald-400', 
            'fa' => 'fas fa-check-circle'
        ],
        'claim_rejected'   => [
            'bg' => 'bg-rose-50 dark:bg-rose-900/20', 
            'icon' => 'text-rose-600 dark:text-rose-400', 
            'fa' => 'fas fa-times-circle'
        ],
        'item_found'       => [
            'bg' => 'bg-indigo-50 dark:bg-indigo-900/20', 
            'icon' => 'text-indigo-600 dark:text-indigo-400', 
            'fa' => 'fas fa-search-location'
        ],
        'admin_log'        => [
            'bg' => 'bg-slate-100 dark:bg-slate-700', 
            'icon' => 'text-slate-600 dark:text-slate-300', 
            'fa' => 'fas fa-user-shield'
        ],
    ];

    $currentStyle = $styles[$type] ?? [
        'bg' => 'bg-slate-100 dark:bg-gray-700', 
        'icon' => 'text-slate-500', 
        'fa' => $icon
    ];
?>

<div class="relative group flex items-start gap-x-5 px-8 py-7 transition-all duration-300 
    <?php echo e($isUnread ? 'bg-indigo-50/40 dark:bg-indigo-900/10' : 'bg-white dark:bg-gray-800'); ?> 
    hover:bg-slate-50 dark:hover:bg-gray-700/50 border-b border-slate-100 dark:border-gray-700 last:border-0">
    
    
    <?php if($isUnread): ?>
        
        <div class="absolute left-0 top-0 bottom-0 w-1 bg-indigo-500 shadow-[2px_0_10px_rgba(99,102,241,0.4)]"></div>
        
        <div class="absolute top-8 right-8 h-2.5 w-2.5 rounded-full bg-indigo-500 animate-pulse border-2 border-white dark:border-gray-800"></div>
    <?php endif; ?>

    
    <div class="flex-none">
        <div class="h-14 w-14 rounded-2xl <?php echo e($currentStyle['bg']); ?> flex items-center justify-center shadow-sm transition-transform duration-300 group-hover:scale-110 group-hover:rotate-3">
            <i class="<?php echo e($currentStyle['fa']); ?> <?php echo e($currentStyle['icon']); ?> text-xl"></i>
        </div>
    </div>

    
    <div class="flex-auto min-w-0">
        <div class="flex flex-col md:flex-row md:justify-between md:items-start mb-2">
            <div>
                <h4 class="text-base font-extrabold tracking-tight <?php echo e($isUnread ? 'text-indigo-950 dark:text-white' : 'text-slate-700 dark:text-slate-300'); ?>">
                    <?php echo e($notification->data['title'] ?? 'System Update'); ?>

                </h4>
                <div class="flex items-center mt-0.5 space-x-2">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">
                        <?php echo e(str_replace('_', ' ', $type)); ?>

                    </span>
                    <span class="text-slate-300 dark:text-slate-600">•</span>
                    <time class="text-[11px] font-medium text-slate-400 italic">
                        <?php echo e($notification->created_at->diffForHumans()); ?>

                    </time>
                </div>
            </div>
        </div>
        
        <p class="text-sm <?php echo e($isUnread ? 'text-slate-700 dark:text-slate-300 font-medium' : 'text-slate-500 dark:text-slate-400'); ?> leading-relaxed max-w-2xl">
            <?php echo e($notification->data['message']); ?>

        </p>

        
        <div class="flex flex-wrap items-center gap-3 mt-5">
            
            <?php if(!empty($notification->data['url'])): ?>
                <a href="<?php echo e($notification->data['url']); ?>" 
                   class="inline-flex items-center gap-x-2 rounded-xl bg-slate-900 dark:bg-indigo-600 px-5 py-2.5 text-xs font-black text-white shadow-lg shadow-slate-200 dark:shadow-none hover:bg-slate-800 dark:hover:bg-indigo-500 transition active:scale-95">
                    <i class="fas fa-eye text-[10px]"></i>
                    <?php echo e(__('View Details')); ?>

                </a>
            <?php endif; ?>

            
            <?php if($isUnread): ?>
                <form action="<?php echo e(route('notifications.destroy', $notification->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" 
                            class="inline-flex items-center gap-x-2 rounded-xl bg-white dark:bg-gray-800 px-5 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-300 shadow-sm ring-1 ring-inset ring-slate-200 dark:ring-gray-600 hover:bg-slate-50 dark:hover:bg-gray-700 transition active:scale-95">
                        <i class="fas fa-trash text-red-500"></i>
                        <?php echo e(__('Delete')); ?>

                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div><?php /**PATH /home/riku/Documents/laravel_poject/lost_n_found/resources/views/notifications/partials/notification_item.blade.php ENDPATH**/ ?>