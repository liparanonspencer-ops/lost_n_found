@extends('layouts.app')

@section('content')
   
    <div id='calendar' style="max-width: 900px; margin: 40px auto;"></div>
@endsection

@push('scripts')
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
@endpush