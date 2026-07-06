@props(['title' => 'Nothing here yet', 'description' => ''])
<div class="flex flex-col items-center justify-center rounded-xl border border-dashed border-gray-300 bg-gray-50/50 px-6 py-16 text-center">
    <span class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-primary-100 text-primary-600">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="7" width="18" height="14" rx="2"/><path d="M16 3v4M8 3v4M3 11h18"/>
        </svg>
    </span>
    <p class="text-sm font-semibold text-gray-700">{{ $title }}</p>
    @if ($description)
        <p class="mt-1 max-w-sm text-sm text-gray-500">{{ $description }}</p>
    @endif
</div>
