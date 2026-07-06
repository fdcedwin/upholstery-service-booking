# Upholstery Service Booking System

A production-quality Laravel booking application for an upholstery service business.
Customers submit appointment requests through a clean public form; admins manage,
approve, reject, and complete bookings from a dashboard, and view everything on a
color-coded calendar.

## Tech stack

- Laravel 10 (PHP 8.1+)
- MySQL
- Blade + Tailwind CSS
- Alpine.js (toasts, mobile sidebar, button loading states)
- FullCalendar.js (loaded via CDN, no extra build step required)

## Features

**Public**
- Booking form with name, contact, service type, date, time, and notes
- Server-side validation (Form Requests) + inline error messages
- Prevents booking a date/time already **approved** for someone else
- Success toast on submission

**Admin** (behind login)
- Dashboard: stat cards, search, status/date filters, paginated table, color-coded status badges, approve/reject/complete/delete actions
- Calendar: month/list view, color-coded events (pending = amber, approved = green, completed = blue, rejected = red)
- Sidebar navigation with mobile toggle
- Simple session-based authentication (no public registration — admins are seeded)

## Project structure highlights

```
app/Http/Controllers/BookingController.php          Public booking form
app/Http/Controllers/Auth/AuthenticatedSessionController.php  Login/logout
app/Http/Controllers/Admin/DashboardController.php   Admin table + filters
app/Http/Controllers/Admin/BookingController.php     Approve/reject/complete/delete
app/Http/Controllers/Admin/CalendarController.php    Calendar page + JSON events feed
app/Http/Requests/StoreBookingRequest.php            Validation + double-booking check
app/Models/Booking.php                               Scopes, status colors/badges, service labels
database/migrations/..._create_bookings_table.php
resources/views/booking/create.blade.php             Public form
resources/views/admin/dashboard.blade.php             Admin table
resources/views/admin/calendar.blade.php              Calendar
resources/views/components/                          Reusable Blade components (toast, badge, inputs...)
```

## Getting started

This repository contains the full application source. Since it was generated
outside of a PHP/Composer environment, install dependencies locally before running it:

```bash
# 1. Install PHP dependencies
composer install

# 2. Copy the environment file and generate an app key
cp .env.example .env
php artisan key:generate

# 3. Configure your database in .env
#    DB_DATABASE=upholstery_booking
#    DB_USERNAME=root
#    DB_PASSWORD=

# 4. Run migrations and seed a demo admin + sample bookings
php artisan migrate --seed

# 5. Install JS dependencies and build assets
npm install
npm run build      # or `npm run dev` while developing

# 6. Serve the app
php artisan serve
```

Visit:
- `http://localhost:8000/` — public booking form
- `http://localhost:8000/login` — admin login

**Demo admin credentials** (created by the seeder):
```
Email:    admin@upholstery.test
Password: password
```

## Running tests

```bash
php artisan test
```

Covers: booking form rendering, successful submission, validation errors,
admin route protection, approval flow, and double-booking prevention.

## Notes on design decisions

- **Single admin role.** There's no public registration flow — admin accounts
  are created via the seeder (or `php artisan tinker` / a custom seeder in
  production). An `admin` middleware alias is included so per-permission
  logic can be added later without touching routes.
- **Double-booking prevention** only blocks a slot once it's *approved*,
  so multiple pending requests for the same slot can still come in and the
  admin decides which one to approve.
- **FullCalendar is loaded via CDN** in `admin/calendar.blade.php` so the
  calendar works even before you wire up a full Vite/npm asset pipeline.
  Swap it for an npm-installed package if you prefer bundling it.
