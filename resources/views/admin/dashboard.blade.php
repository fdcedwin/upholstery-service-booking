<x-layouts.admin title="Dashboard">

    {{-- Stat cards --}}
    <div class="mb-6 grid grid-cols-2 gap-4 lg:grid-cols-4">
        @php
            $stats = [
                ['label' => 'Pending', 'count' => $statusCounts['pending'], 'color' => 'text-amber-600 bg-amber-100', 'status' => 'pending'],
                ['label' => 'Approved', 'count' => $statusCounts['approved'], 'color' => 'text-emerald-600 bg-emerald-100', 'status' => 'approved'],
                ['label' => 'Completed', 'count' => $statusCounts['completed'], 'color' => 'text-sky-600 bg-sky-100', 'status' => 'completed'],
                ['label' => 'Rejected', 'count' => $statusCounts['rejected'], 'color' => 'text-rose-600 bg-rose-100', 'status' => 'rejected'],
            ];
        @endphp
        @foreach ($stats as $stat)
            <a href="{{ route('admin.dashboard', ['status' => $stat['status']]) }}" class="card flex items-center gap-4 p-4 transition hover:-translate-y-0.5 hover:shadow-lg sm:p-5">
                <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg {{ $stat['color'] }} text-lg font-bold">
                    {{ $stat['count'] }}
                </span>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-500">{{ $stat['label'] }}</p>
                </div>
            </a>
        @endforeach
    </div>

    {{-- Filters --}}
    <div class="card mb-6 p-4 sm:p-5">
        <form method="GET" action="{{ route('admin.dashboard') }}" class="flex flex-col gap-3 sm:flex-row sm:items-end sm:gap-4">
            <div class="flex-1">
                <label class="form-label" for="search">Search</label>
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                    </svg>
                    <input type="text" id="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search name or contact&hellip;" class="form-input pl-9">
                </div>
            </div>

            <div class="w-full sm:w-48">
                <label class="form-label" for="status">Status</label>
                <select id="status" name="status" class="form-input">
                    <option value="">All statuses</option>
                    @foreach (['pending', 'approved', 'completed', 'rejected'] as $status)
                        <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="w-full sm:w-48">
                <label class="form-label" for="date">Date</label>
                <input type="date" id="date" name="date" value="{{ $filters['date'] ?? '' }}" class="form-input">
            </div>

            <div class="flex gap-2">
                <button type="submit" class="btn-primary">Filter</button>
                @if (array_filter($filters))
                    <a href="{{ route('admin.dashboard') }}" class="btn-secondary">Clear</a>
                @endif
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="card overflow-hidden">
        @if ($bookings->isEmpty())
            <div class="p-6">
                <x-empty-state title="No bookings found" description="Try adjusting your filters, or wait for new appointment requests to come in." />
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100 text-left text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="whitespace-nowrap px-5 py-3 font-semibold text-gray-500">Customer</th>
                            <th class="whitespace-nowrap px-5 py-3 font-semibold text-gray-500">Service</th>
                            <th class="whitespace-nowrap px-5 py-3 font-semibold text-gray-500">Date &amp; time</th>
                            <th class="whitespace-nowrap px-5 py-3 font-semibold text-gray-500">Status</th>
                            <th class="whitespace-nowrap px-5 py-3 font-semibold text-gray-500 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($bookings as $booking)
                            <tr class="transition hover:bg-gray-50/60">
                                <td class="whitespace-nowrap px-5 py-4">
                                    <p class="font-medium text-gray-900">{{ $booking->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $booking->contact }}</p>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-gray-600">{{ $booking->service_type_label }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-gray-600">
                                    {{ $booking->booking_date->format('M d, Y') }}
                                    <span class="text-gray-400">&middot;</span>
                                    {{ \Illuminate\Support\Carbon::parse($booking->booking_time)->format('g:i A') }}
                                </td>
                                <td class="whitespace-nowrap px-5 py-4">
                                    <x-status-badge :status="$booking->status" />
                                </td>
                                <td class="whitespace-nowrap px-5 py-4">
                                    <div class="flex justify-end gap-2">
                                        @if ($booking->status === 'pending')
                                            <form method="POST" action="{{ route('admin.bookings.approve', $booking) }}">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="btn-success btn-sm">Approve</button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.bookings.reject', $booking) }}">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="btn-danger btn-sm">Reject</button>
                                            </form>
                                        @elseif ($booking->status === 'approved')
                                            <form method="POST" action="{{ route('admin.bookings.complete', $booking) }}">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="btn-secondary btn-sm">Mark completed</button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.bookings.reject', $booking) }}">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="btn-danger btn-sm">Reject</button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}"
                                                  onsubmit="return confirm('Delete this booking permanently?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn-secondary btn-sm">Delete</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="border-t border-gray-100 px-5 py-4">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
