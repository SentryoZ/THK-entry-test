<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Models\Hotel;

class BookingController extends Controller
{
    public function index()
    {
        return Booking::all();
    }

    public function create()
    {
        $hotels = Hotel::all();

        return view('admin.booking.new', [
            'hotels' => $hotels
        ]);
    }

    public function store(BookingRequest $request)
    {
        return Booking::query()->create($request->validated());
    }

    public function edit(Booking $booking)
    {
        $hotels = Hotel::all();

        return view('admin.booking.edit', [
            'hotels' => $hotels,
            'booking' => $booking
        ]);
    }

    public function update(BookingRequest $request, Booking $booking)
    {
        $booking->update($request->validated());

        return $booking;
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return response()->json();
    }
}
