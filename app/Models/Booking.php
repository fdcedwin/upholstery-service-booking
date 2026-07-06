<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_COMPLETED = 'completed';

    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_APPROVED,
        self::STATUS_REJECTED,
        self::STATUS_COMPLETED,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'contact',
        'service_type',
        'booking_date',
        'booking_time',
        'status',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'booking_date' => 'date',
    ];

    /**
     * Always store the time as H:i:s so comparisons are consistent
     * regardless of the database driver (MySQL TIME column vs SQLite text).
     */
    public function setBookingTimeAttribute(string $value): void
    {
        $this->attributes['booking_time'] = \Illuminate\Support\Carbon::parse($value)->format('H:i:s');
    }

    /**
     * Human friendly labels for each service type value.
     *
     * @return array<string, string>
     */
    public static function serviceTypes(): array
    {
        return [
            'sofa_reupholstery' => 'Sofa Reupholstery',
            'chair_reupholstery' => 'Chair Reupholstery',
            'cushion_replacement' => 'Cushion Replacement',
            'leather_repair' => 'Leather Repair',
            'fabric_cleaning' => 'Fabric Cleaning',
            'custom_furniture' => 'Custom Furniture Upholstery',
            'other' => 'Other',
        ];
    }

    public function getServiceTypeLabelAttribute(): string
    {
        return self::serviceTypes()[$this->service_type] ?? ucfirst(str_replace('_', ' ', $this->service_type));
    }

    /**
     * Scope a query to only include bookings with the given status.
     */
    public function scopeStatus(Builder $query, ?string $status): Builder
    {
        return $status ? $query->where('status', $status) : $query;
    }

    /**
     * Scope a query to only include bookings on the given date.
     */
    public function scopeOnDate(Builder $query, ?string $date): Builder
    {
        return $date ? $query->whereDate('booking_date', $date) : $query;
    }

    /**
     * Determine whether the requested date/time slot is already approved for another booking.
     */
    public static function slotIsTaken(string $date, string $time, ?int $ignoreId = null): bool
    {
        $normalizedTime = \Illuminate\Support\Carbon::parse($time)->format('H:i:s');

        return static::query()
            ->whereDate('booking_date', $date)
            ->where('booking_time', $normalizedTime)
            ->where('status', self::STATUS_APPROVED)
            ->when($ignoreId, fn (Builder $query) => $query->whereKeyNot($ignoreId))
            ->exists();
    }

    /**
     * Tailwind badge classes for each status, used across the admin UI.
     */
    public function statusBadgeClasses(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'bg-amber-100 text-amber-800 ring-1 ring-inset ring-amber-200',
            self::STATUS_APPROVED => 'bg-emerald-100 text-emerald-800 ring-1 ring-inset ring-emerald-200',
            self::STATUS_COMPLETED => 'bg-sky-100 text-sky-800 ring-1 ring-inset ring-sky-200',
            self::STATUS_REJECTED => 'bg-rose-100 text-rose-800 ring-1 ring-inset ring-rose-200',
            default => 'bg-gray-100 text-gray-800 ring-1 ring-inset ring-gray-200',
        };
    }

    /**
     * Hex color used for the calendar event dot/background per status.
     */
    public function calendarColor(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => '#d97706',
            self::STATUS_APPROVED => '#059669',
            self::STATUS_COMPLETED => '#0284c7',
            self::STATUS_REJECTED => '#e11d48',
            default => '#6b7280',
        };
    }
}
