<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_booking_form_renders(): void
    {
        $this->get(route('booking.create'))->assertOk();
    }

    public function test_a_visitor_can_submit_a_booking_request(): void
    {
        $response = $this->post(route('booking.store'), [
            'name' => 'Jane Dela Cruz',
            'contact' => '09171234567',
            'service_type' => 'sofa_reupholstery',
            'booking_date' => now()->addDay()->format('Y-m-d'),
            'booking_time' => '10:00',
            'notes' => 'Blue linen fabric preferred.',
        ]);

        $response->assertRedirect(route('booking.create'));
        $this->assertDatabaseHas('bookings', [
            'name' => 'Jane Dela Cruz',
            'status' => Booking::STATUS_PENDING,
        ]);
    }

    public function test_booking_requires_required_fields(): void
    {
        $this->post(route('booking.store'), [])
            ->assertSessionHasErrors(['name', 'contact', 'service_type', 'booking_date', 'booking_time']);
    }

    public function test_guests_cannot_access_the_admin_dashboard(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    }

    public function test_an_admin_can_approve_a_pending_booking(): void
    {
        $admin = User::factory()->create();
        $booking = Booking::factory()->create(['status' => Booking::STATUS_PENDING]);

        $this->actingAs($admin)
            ->patch(route('admin.bookings.approve', $booking))
            ->assertRedirect();

        $this->assertEquals(Booking::STATUS_APPROVED, $booking->fresh()->status);
    }

    public function test_double_booking_the_same_approved_slot_is_prevented(): void
    {
        $admin = User::factory()->create();

        $approved = Booking::factory()->create([
            'status' => Booking::STATUS_APPROVED,
            'booking_date' => '2026-08-01',
            'booking_time' => '10:00',
        ]);

        $conflicting = Booking::factory()->create([
            'status' => Booking::STATUS_PENDING,
            'booking_date' => '2026-08-01',
            'booking_time' => '10:00',
        ]);

        $this->actingAs($admin)
            ->patch(route('admin.bookings.approve', $conflicting))
            ->assertRedirect();

        $this->assertEquals(Booking::STATUS_PENDING, $conflicting->fresh()->status);
    }
}
