<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\RedirectResponse;

class BookingController extends Controller
{
    /**
     * Approve a booking, guarding against double-booking the same slot.
     */
    public function approve(Booking $booking): RedirectResponse
    {
        if (Booking::slotIsTaken($booking->booking_date->format('Y-m-d'), $booking->booking_time, $booking->id)) {
            return back()->with('error', 'Another booking already occupies this date and time slot.');
        }

        $booking->update(['status' => Booking::STATUS_APPROVED]);

        return back()->with('success', "Booking for {$booking->name} approved.");
    }

    /**
     * Reject a booking.
     */
    public function reject(Booking $booking): RedirectResponse
    {
        $booking->update(['status' => Booking::STATUS_REJECTED]);

        return back()->with('success', "Booking for {$booking->name} rejected.");
    }

    /**
     * Mark a booking as completed.
     */
    public function complete(Booking $booking): RedirectResponse
    {
        $booking->update(['status' => Booking::STATUS_COMPLETED]);

        return back()->with('success', "Booking for {$booking->name} marked as completed.");
    }

    /**
     * Delete a booking permanently.
     */
    public function destroy(Booking $booking): RedirectResponse
    {
        $booking->delete();

        return back()->with('success', 'Booking removed.');
    }
}
