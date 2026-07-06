@props(['status'])

@php
    $classes = match($status) {
        'pending' => 'bg-amber-100 text-amber-800 ring-1 ring-inset ring-amber-200',
        'approved' => 'bg-emerald-100 text-emerald-800 ring-1 ring-inset ring-emerald-200',
        'completed' => 'bg-sky-100 text-sky-800 ring-1 ring-inset ring-sky-200',
        'rejected' => 'bg-rose-100 text-rose-800 ring-1 ring-inset ring-rose-200',
        default => 'bg-gray-100 text-gray-800 ring-1 ring-inset ring-gray-200',
    };

    $dot = match($status) {
        'pending' => 'bg-amber-500',
        'approved' => 'bg-emerald-500',
        'completed' => 'bg-sky-500',
        'rejected' => 'bg-rose-500',
        default => 'bg-gray-500',
    };
@endphp

<span {{ $attributes->merge(['class' => "badge $classes"]) }}>
    <span class="mr-1.5 h-1.5 w-1.5 rounded-full {{ $dot }}"></span>
    {{ ucfirst($status) }}
</span>
