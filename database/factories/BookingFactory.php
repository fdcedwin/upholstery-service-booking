<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'contact' => $this->faker->numerify('09#########'),
            'service_type' => $this->faker->randomElement(array_keys(Booking::serviceTypes())),
            'booking_date' => $this->faker->dateTimeBetween('-5 days', '+21 days')->format('Y-m-d'),
            'booking_time' => $this->faker->randomElement(['09:00', '10:30', '13:00', '14:30', '16:00']),
            'status' => $this->faker->randomElement(Booking::STATUSES),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
