<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display a paginated, filterable list of bookings for the admin.
     */
    public function index(Request $request): View
    {
        $bookings = Booking::query()
            ->status($request->query('status'))
            ->onDate($request->query('date'))
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->query('search');
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('contact', 'like', "%{$search}%");
                });
            })
            ->latest('booking_date')
            ->latest('booking_time')
            ->paginate(10)
            ->withQueryString();

        return view('admin.dashboard', [
            'bookings' => $bookings,
            'statusCounts' => [
                'pending' => Booking::status(Booking::STATUS_PENDING)->count(),
                'approved' => Booking::status(Booking::STATUS_APPROVED)->count(),
                'completed' => Booking::status(Booking::STATUS_COMPLETED)->count(),
                'rejected' => Booking::status(Booking::STATUS_REJECTED)->count(),
            ],
            'filters' => $request->only(['status', 'date', 'search']),
        ]);
    }
}
