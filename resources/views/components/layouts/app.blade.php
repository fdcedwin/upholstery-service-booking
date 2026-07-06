<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Upholstery Booking' }} &mdash; {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full min-h-screen bg-gradient-to-b from-primary-50 via-gray-50 to-gray-50">

    <header class="border-b border-gray-100 bg-white/70 backdrop-blur">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-4 py-4 sm:px-6">
            <a href="{{ route('booking.create') }}" class="flex items-center gap-2.5">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary-600 text-white shadow-soft">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 12h18M3 12a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2M3 12v6a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1h12v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-6M7 10V8a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2"/>
                    </svg>
                </span>
                <span class="text-lg font-bold tracking-tight text-gray-900">StitchCraft Upholstery</span>
            </a>
            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-500 hover:text-primary-600 transition">Admin login</a>
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-4 py-10 sm:px-6 sm:py-16">
        {{ $slot }}
    </main>

    <footer class="mx-auto max-w-5xl px-4 pb-10 text-center text-xs text-gray-400 sm:px-6">
        &copy; {{ date('Y') }} StitchCraft Upholstery. All rights reserved.
    </footer>

    <x-toast />
</body>
</html>
