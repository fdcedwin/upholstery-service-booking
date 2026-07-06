<x-layouts.app title="Book a Service">
    <div class="mx-auto max-w-2xl">

        <div class="mb-8 text-center">
            <span class="badge bg-primary-100 text-primary-700 mb-4">Free Estimate &middot; No Obligation</span>
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                Book Your Upholstery Service
            </h1>
            <p class="mx-auto mt-3 max-w-md text-gray-500">
                Tell us a bit about your furniture and pick a date &mdash; we'll confirm your appointment shortly after.
            </p>
        </div>

        <div class="card p-6 sm:p-8">
            <form method="POST" action="{{ route('booking.store') }}" class="space-y-6" x-data="{ submitting: false }" @submit="submitting = true">
                @csrf

                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <x-input-label for="name" value="Full name" />
                        <x-text-input id="name" name="name" type="text" placeholder="Juan Dela Cruz"
                            value="{{ old('name') }}" required autofocus />
                        <x-input-error :messages="$errors->first('name')" />
                    </div>

                    <div>
                        <x-input-label for="contact" value="Contact number" />
                        <x-text-input id="contact" name="contact" type="text" placeholder="09xx xxx xxxx"
                            value="{{ old('contact') }}" required />
                        <x-input-error :messages="$errors->first('contact')" />
                    </div>
                </div>

                <div>
                    <x-input-label for="service_type" value="Service type" />
                    <select id="service_type" name="service_type" required class="form-input">
                        <option value="" disabled {{ old('service_type') ? '' : 'selected' }}>Select a service&hellip;</option>
                        @foreach ($serviceTypes as $value => $label)
                            <option value="{{ $value }}" @selected(old('service_type') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->first('service_type')" />
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <x-input-label for="booking_date" value="Preferred date" />
                        <x-text-input id="booking_date" name="booking_date" type="date"
                            min="{{ now()->format('Y-m-d') }}" value="{{ old('booking_date') }}" required />
                        <x-input-error :messages="$errors->first('booking_date')" />
                    </div>

                    <div>
                        <x-input-label for="booking_time" value="Preferred time" />
                        <x-text-input id="booking_time" name="booking_time" type="time"
                            value="{{ old('booking_time') }}" required />
                        <x-input-error :messages="$errors->first('booking_time')" />
                    </div>
                </div>

                <div>
                    <x-input-label for="notes" value="Notes (optional)" />
                    <textarea id="notes" name="notes" rows="4" class="form-input resize-none"
                        placeholder="Describe the item(s), fabric preference, or anything else we should know.">{{ old('notes') }}</textarea>
                    <x-input-error :messages="$errors->first('notes')" />
                </div>

                <button type="submit" :disabled="submitting" class="btn-primary w-full">
                    <svg x-show="submitting" x-cloak class="h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <span x-text="submitting ? 'Submitting…' : 'Request Appointment'"></span>
                </button>
            </form>
        </div>

        <p class="mt-6 text-center text-xs text-gray-400">
            Submitting this form does not confirm your booking. Our team will review and confirm availability.
        </p>
    </div>
</x-layouts.app>
