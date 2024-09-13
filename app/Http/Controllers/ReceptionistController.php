<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Checkin;
use App\Models\Checkout;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReceptionistController extends Controller
{
    public function checkinForm()
    {
        // Hanya booking yang memiliki transaksi dengan status 'valid'
        $bookings = Booking::with(['user', 'room', 'snack', 'transaction' => function($query) {
            $query->where('status', 'valid');
        }])
        ->whereDoesntHave('checkin')
        ->whereHas('transaction', function($query) {
            $query->where('status', 'valid');
        })
        ->get();

        return view('resepsionis.checkin', compact('bookings'));
    }

    public function checkinDetails(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
        ]);

        $booking = Booking::with('transaction')->find($request->booking_id);

        // Check if the booking has a valid transaction
        $paymentCompleted = $booking->transaction && $booking->transaction->status === 'valid' ? true : false;

        return view('resepsionis.checkin_details', compact('booking', 'paymentCompleted'));
    }


    public function checkin(Request $request) {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
        ]);

        $booking = Booking::with('transaction')->find($request->booking_id);

        // Ensure payment is completed
        if (!$booking->transaction || $booking->transaction->status !== 'valid') {
            return redirect()->route('resepsionis.checkin.details', ['booking_id' => $booking->id])
                             ->with('error', 'Payment must be completed and valid before check-in.');
        }

        $today = Carbon::now()->startOfDay();
        $bookingDate = Carbon::parse($booking->tgl)->startOfDay();

        if ($today->equalTo($bookingDate)) {
            Checkin::create([
                'booking_id' => $booking->id,
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('resepsionis.checkin.form')->with('message', 'Check-in successful.');
        } else {
            return redirect()->back()->with('error', 'Check-in not allowed for this booking date.');
        }
    }

    public function checkoutForm()
    {
        $bookings = Booking::with('user', 'room', 'snack')
            ->whereHas('checkin') // Ensure the booking has been checked in
            ->whereDoesntHave('checkout') // Exclude bookings that have already been checked out
            ->get();
        return view('resepsionis.checkout', compact('bookings'));
    }

    public function checkoutDetails(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
        ]);

        $booking = Booking::with('transaction')->find($request->booking_id);

        // Check if the booking has a valid transaction
        $paymentCompleted = $booking->transaction ? true : false;

        return view('resepsionis.checkout_details', compact('booking', 'paymentCompleted'));
    }

    public function checkout(Request $request) {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'keterangan' => 'nullable|string',
        ]);

        $booking = Booking::with('transaction')->find($request->booking_id);
        // Ensure payment is completed
        if (!$booking->transaction) {
            return redirect()->route('resepsionis.checkout.details', ['booking_id' => $booking->id])
                            ->with('error', 'Payment must be completed before check-out.');
        }

        // Create checkout record
        Checkout::create([
            'booking_id' => $booking->id,
            'user_id' => Auth::id(),
            'keterangan' => $request->keterangan,
        ]);

        // Increase room count back
        $room = $booking->room;
        $room->jumlah += 1;
        $room->save();

        return redirect()->route('resepsionis.checkout.form')->with('message', 'Check-out successful.');
    }

    public function validatePaymentForm()
    {
        $transactions = Transaction::with('booking.user', 'booking.room', 'booking.snack')
                            ->where('status', 'pending')
                            ->get();
        return view('resepsionis.validate_payment', compact('transactions'));
    }

    public function validatePayment(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'status' => 'required|in:valid,invalid',
        ]);

        $transaction = Transaction::find($request->transaction_id);
        $oldStatus = $transaction->status;
        $transaction->status = $request->status;
        $transaction->save();

        if ($oldStatus != 'invalid' && $request->status == 'invalid') {
            // Increase room count back if transaction becomes invalid
            $booking = $transaction->booking;
            $room = $booking->room;
            $room->jumlah += 1;
            $room->save();
        }

        return redirect()->route('resepsionis.validate.payment.form')->with('message', 'Payment status updated successfully.');
    }
}
