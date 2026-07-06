<x-layouts.app title="Admin Login">
    <div class="mx-auto flex max-w-md flex-col justify-center">
        <div class="mb-8 text-center">
            <h1 class="text-2xl font-extrabold tracking-tight text-gray-900">Admin Sign In</h1>
            <p class="mt-2 text-sm text-gray-500">Manage bookings, approvals, and the schedule.</p>
        </div>

        <div class="card p-6 sm:p-8">
            <form method="POST" action="{{ route('login') }}" class="space-y-5" x-data="{ submitting: false }" @submit="submitting = true">
                @csrf

                <div>
                    <x-input-label for="email" value="Email address" />
                    <x-text-input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus placeholder="admin@upholstery.test" />
                    <x-input-error :messages="$errors->first('email')" />
                </div>

                <div>
                    <x-input-label for="password" value="Password" />
                    <x-text-input id="password" name="password" type="password" required placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" />
                    <x-input-error :messages="$errors->first('password')" />
                </div>

                <label class="flex items-center gap-2 text-sm text-gray-600">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                    Remember me
                </label>

                <button type="submit" :disabled="submitting" class="btn-primary w-full">
                    <svg x-show="submitting" x-cloak class="h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <span x-text="submitting ? 'Signing in…' : 'Sign in'"></span>
                </button>
            </form>
        </div>

        <p class="mt-6 text-center text-xs text-gray-400">
            Demo credentials: admin@upholstery.test / password
        </p>
    </div>
</x-layouts.app>
