<?php $__env->startSection('content'); ?>
   
    <div id='calendar' style="max-width: 900px; margin: 40px auto;"></div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: '/api/events',
            
            // Example: Alert when clicking a date
            dateClick: function(info) {
                let title = prompt('Enter Event Title:');
                if (title) {
                    // You'd use fetch() or axios here to POST to your Laravel controller
                    console.log('Save to DB: ' + title + ' on ' + info.dateStr);
                }
            }
        });
        calendar.render();
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/riku/Documents/laravel_poject/lost_n_found/resources/views/calendar.blade.php ENDPATH**/ ?>