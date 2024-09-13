<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Snack;
use App\Models\Booking;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class UserController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('user.index', compact('rooms'));
    }

    public function detail_ruangan($id)
    {
        $room = Room::find($id);
        if (!$room) {
            return redirect()->back()->with('error', 'Room not found.');
        }
        $snacks = Snack::all();
        return view('user.detail_ruangan', compact('room', 'snacks'));
    }

    public function booking(Request $request, $id)
    {
        \Log::info('Booking function called');
        $room = Room::find($id);
        if (!$room) {
            return redirect()->back()->with('error', 'Room not found.');
        }

        \Log::info('Room found: ' . $room->id);

        $request->validate([
            'no_tlp' => 'required|string|max:255',
            'jml_orang' => 'required|integer|min:1|max:' . $room->kapasitas,
            'tgl' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'snack_id' => 'nullable|exists:snacks,id', // Ensure the snack_id exists in snacks table
        ]);

        $snack_id = null;
        if ($request->filled('snack_id')) {
            $snack_id = $request->snack_id;
        }

        $snack_id = $request->snack_id ?? null;
        $booking = new Booking();
        $booking->room_id = $id;
        $booking->user_id = Auth::id();
        $booking->no_tlp = $request->no_tlp;
        $booking->jml_orang = $request->jml_orang;
        $booking->tgl = $request->tgl;
        $booking->jam_mulai = $request->jam_mulai;
        $booking->jam_selesai = $request->jam_selesai;
        $booking->snack_id = $snack_id;

        // Save booking and check for success
        if ($booking->save()) {
            return redirect()->back()->with('success', 'Booking successful.');
        } else {
            return redirect()->back()->with('error', 'Booking failed. Please try again.');
        }
    }

    public function riwayat_booking()
    {
        $user = Auth::user();
        $bookings = Booking::where('user_id', $user->id)->with(['room', 'snack', 'transaction'])->get();

        return view('user.riwayat_booking', compact('bookings'));
    }

    public function payBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $room_price = $booking->room->harga;
        $hours = (strtotime($booking->jam_selesai) - strtotime($booking->jam_mulai)) / 3600;
        $room_total = $room_price * $hours;
        $snack_total = $booking->snack ? $booking->snack->harga * $booking->jml_orang : 0;
        $total_harga = $room_total + $snack_total;
    
        return view('user.payment', compact('booking', 'room_total', 'snack_total', 'total_harga', 'hours'));
    }
    

    public function processPayment(Request $request, $id)
    {
        $request->validate([
            'metode' => 'required|string|max:255',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $booking = Booking::find($id);
        if ($booking && $booking->user_id == Auth::id()) {
            $total_harga = $booking->calculateTotalPrice();

            // Save file proof of payment in storage/public/payments
            $path = $request->file('bukti_pembayaran')->store('payments', 'public');

            // Save transaction to database
            Transaction::create([
                'metode' => $request->metode,
                'total_harga' => $total_harga,
                'bukti_pembayaran' => $path,
                'booking_id' => $booking->id,
            ]);

            return redirect()->route('riwayat_booking')->with('success', 'Payment successful.');
        }

        return redirect()->back()->with('error', 'Booking not found.');
    }
    
    public function cancelBooking($id)
    {
        $booking = Booking::find($id);

        if ($booking) {
            // Mengecek apakah booking dapat dibatalkan
            if (!$booking->transaction) {
                // Hitung waktu H-2 (48 jam sebelum tanggal dan jam mulai booking)
                $h2BeforeBooking = Carbon::parse($booking->tgl . ' ' . $booking->jam_mulai)->subHours(48);
                $now = Carbon::now();

                // Debug informasi waktu
                \Log::info('Waktu sekarang: ' . $now);
                \Log::info('Waktu H-2: ' . $h2BeforeBooking);

                // Periksa apakah waktu saat ini sebelum H-2
                if ($now < $h2BeforeBooking) {
                    \Log::info('Booking dapat dibatalkan');
                    $booking->delete();
                    return response()->json(['success' => true, 'message' => 'Booking successfully cancelled.']);
                } else {
                    \Log::info('Booking tidak dapat dibatalkan, sudah H-2');
                    return response()->json(['success' => false, 'message' => 'Booking cannot be cancelled as it is within the H-2 period.']);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Booking with successful payment cannot be cancelled.']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Booking not found.']);
        }
    }
    
}