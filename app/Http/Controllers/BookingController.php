<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Show the public booking form.
     */
    public function create(): View
    {
        return view('booking.create', [
            'serviceTypes' => Booking::serviceTypes(),
        ]);
    }

    /**
     * Store a newly submitted booking request as "pending".
     */
    public function store(StoreBookingRequest $request): RedirectResponse
    {
        Booking::create([
            ...$request->validated(),
            'status' => Booking::STATUS_PENDING,
        ]);

        return redirect()
            ->route('booking.create')
            ->with('success', 'Your booking request has been submitted! We will contact you shortly to confirm.');
    }
}
