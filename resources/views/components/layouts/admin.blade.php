<!DOCTYPE html>
<html lang="en" class="h-full" x-data="{ sidebarOpen: false }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Dashboard' }} &mdash; Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gray-100">
<div class="flex min-h-screen">

    {{-- Mobile overlay --}}
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
         class="fixed inset-0 z-30 bg-gray-900/40 lg:hidden" x-transition.opacity></div>

    {{-- Sidebar --}}
    <aside
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col bg-primary-900 text-white transition-transform duration-200 ease-in-out lg:static lg:translate-x-0">
        <div class="flex items-center gap-2.5 px-6 py-5">
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 12h18M3 12a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2M3 12v6a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1h12v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-6M7 10V8a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2"/>
                </svg>
            </span>
            <span class="text-base font-bold tracking-tight">StitchCraft</span>
        </div>

        <nav class="mt-4 flex-1 space-y-1 px-3">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white' : 'text-primary-100 hover:bg-white/5 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="9" rx="1.5"/><rect x="14" y="3" width="7" height="5" rx="1.5"/><rect x="14" y="12" width="7" height="9" rx="1.5"/><rect x="3" y="16" width="7" height="5" rx="1.5"/>
                </svg>
                Dashboard
            </a>
            <a href="{{ route('admin.calendar') }}"
               class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.calendar') ? 'bg-white/10 text-white' : 'text-primary-100 hover:bg-white/5 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="17" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                </svg>
                Calendar
            </a>
            <a href="{{ route('booking.create') }}" target="_blank"
               class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-primary-100 transition hover:bg-white/5 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><path d="M15 3h6v6"/><path d="M10 14 21 3"/>
                </svg>
                View public form
            </a>
        </nav>

        <div class="border-t border-white/10 px-3 py-4">
            <div class="mb-3 flex items-center gap-3 rounded-lg px-3 py-2">
                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-primary-600 text-xs font-bold">
                    {{ Str::of(auth()->user()->name ?? 'A')->substr(0, 1)->upper() }}
                </span>
                <div class="min-w-0">
                    <p class="truncate text-sm font-medium text-white">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="truncate text-xs text-primary-200">{{ auth()->user()->email ?? '' }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-primary-100 transition hover:bg-white/5 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/>
                    </svg>
                    Sign out
                </button>
            </form>
        </div>
    </aside>

    {{-- Main content --}}
    <div class="flex min-w-0 flex-1 flex-col">
        <header class="sticky top-0 z-20 flex items-center justify-between border-b border-gray-200 bg-white/80 px-4 py-3.5 backdrop-blur sm:px-6">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = true" class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <h1 class="text-lg font-semibold text-gray-900">{{ $title ?? 'Dashboard' }}</h1>
            </div>
        </header>

        <main class="flex-1 px-4 py-6 sm:px-6 sm:py-8">
            {{ $slot }}
        </main>
    </div>
</div>

<x-toast />
</body>
</html>
