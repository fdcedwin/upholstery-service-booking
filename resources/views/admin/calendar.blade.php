<x-layouts.admin title="Calendar">
    <div class="mb-6 flex flex-wrap items-center gap-4">
        @foreach ([
            ['label' => 'Pending', 'dot' => 'bg-amber-500'],
            ['label' => 'Approved', 'dot' => 'bg-emerald-500'],
            ['label' => 'Completed', 'dot' => 'bg-sky-500'],
            ['label' => 'Rejected', 'dot' => 'bg-rose-500'],
        ] as $legend)
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <span class="h-2.5 w-2.5 rounded-full {{ $legend['dot'] }}"></span>
                {{ $legend['label'] }}
            </div>
        @endforeach
    </div>

    <div class="card p-4 sm:p-6">
        <div id="booking-calendar"></div>
    </div>

    {{-- FullCalendar via CDN (works without an npm build step) --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.11/index.global.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.11/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const el = document.getElementById('booking-calendar');

            const calendar = new FullCalendar.Calendar(el, {
                initialView: window.innerWidth < 640 ? 'listWeek' : 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: window.innerWidth < 640 ? 'listWeek,dayGridMonth' : 'dayGridMonth,listWeek',
                },
                height: 'auto',
                events: "{{ route('admin.calendar.events') }}",
                eventDidMount: function (info) {
                    const notes = info.event.extendedProps.notes;
                    info.el.title = `${info.event.title} — ${info.event.extendedProps.status}` + (notes ? `\nNotes: ${notes}` : '');
                },
            });

            calendar.render();
        });
    </script>
</x-layouts.admin>
