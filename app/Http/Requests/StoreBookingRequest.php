<?php

namespace App\Http\Requests;

use App\Models\Booking;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'max:30'],
            'service_type' => ['required', Rule::in(array_keys(Booking::serviceTypes()))],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'booking_time' => ['required', 'date_format:H:i'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'booking_date.after_or_equal' => 'Please choose today or a future date for your appointment.',
            'booking_time.date_format' => 'Please choose a valid appointment time.',
        ];
    }

    /**
     * Additional validation to prevent booking a slot that is already approved.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->filled(['booking_date', 'booking_time'])
                && Booking::slotIsTaken($this->input('booking_date'), $this->input('booking_time'))) {
                $validator->errors()->add(
                    'booking_time',
                    'This date and time is already booked. Please choose another slot.'
                );
            }
        });
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'contact' => 'contact number',
            'service_type' => 'service type',
            'booking_date' => 'date',
            'booking_time' => 'time',
        ];
    }
}
