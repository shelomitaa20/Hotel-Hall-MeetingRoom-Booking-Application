<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReceptionistController;

// Home route
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
    Route::get('/tambah_ruangan', [AdminController::class, 'tambah_ruangan']);
    Route::post('/tambah_data', [AdminController::class, 'tambah_data']);
    Route::get('/lihat_ruangan', [AdminController::class, 'lihat_ruangan']);
});

// user routes
Route::middleware(['auth', 'role:pengunjung'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user'); 
    Route::get('detail_ruangan/{id}', [UserController::class, 'detail_ruangan'])->name('detail_ruangan');
    Route::post('booking/{id}', [UserController::class, 'booking'])->name('booking');
    Route::get('riwayat_booking', [UserController::class, 'riwayat_booking'])->name('riwayat_booking');
    Route::post('booking/pay/{id}', [UserController::class, 'payBooking'])->name('booking.pay');
    Route::post('booking/process-payment/{id}', [UserController::class, 'processPayment'])->name('booking.process-payment');

    Route::delete('booking/cancel/{id}', [UserController::class, 'cancelBooking'])->name('cancelBooking');
});

// Receptionist routes
Route::middleware(['auth', 'role:resepsionis'])->group(function () {
    Route::get('resepsionis/checkin', [ReceptionistController::class, 'checkinForm'])->name('resepsionis.checkin.form');
    Route::post('resepsionis/checkin-details', [ReceptionistController::class, 'checkinDetails'])->name('resepsionis.checkin.details');
    Route::post('resepsionis/checkin', [ReceptionistController::class, 'checkin'])->name('resepsionis.checkin');
    Route::get('resepsionis/checkout', [ReceptionistController::class, 'checkoutForm'])->name('resepsionis.checkout.form');
    Route::post('resepsionis/checkout-details', [ReceptionistController::class, 'checkoutDetails'])->name('resepsionis.checkout.details');
    Route::post('resepsionis/checkout', [ReceptionistController::class, 'checkout'])->name('resepsionis.checkout');
    Route::post('booking/process-payment/{booking}', [UserController::class, 'processPayment'])->name('booking.process.payment');

    Route::get('resepsionis/validate-payment', [ReceptionistController::class, 'validatePaymentForm'])->name('resepsionis.validate.payment.form');
    Route::post('resepsionis/validate-payment', [ReceptionistController::class, 'validatePayment'])->name('resepsionis.validate.payment');
});