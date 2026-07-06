<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CalendarController extends Controller
{
    /**
     * Display the calendar page shell (events are fetched via AJAX).
     */
    public function index(): View
    {
        return view('admin.calendar');
    }

    /**
     * Return bookings as FullCalendar-compatible JSON events.
     */
    public function events(): JsonResponse
    {
        $events = Booking::query()
            ->get()
            ->map(function (Booking $booking) {
                return [
                    'id' => $booking->id,
                    'title' => "{$booking->name} \u{2013} {$booking->service_type_label}",
                    'start' => $booking->booking_date->format('Y-m-d')."T{$booking->booking_time}",
                    'backgroundColor' => $booking->calendarColor(),
                    'borderColor' => $booking->calendarColor(),
                    'extendedProps' => [
                        'status' => $booking->status,
                        'contact' => $booking->contact,
                        'notes' => $booking->notes,
                    ],
                ];
            });

        return response()->json($events);
    }
}
