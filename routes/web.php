<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourtController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\MembershipController;
use Illuminate\Support\Facades\Route;

// 1. Guest / Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/courts', [CourtController::class, 'index'])->name('courts.index');
Route::get('/courts/{court}', [CourtController::class, 'show'])->name('courts.show');
Route::get('/tournaments', [TournamentController::class, 'index'])->name('tournaments.index');
Route::get('/tournaments/{tournament}', [TournamentController::class, 'show'])->name('tournaments.show');
Route::get('/memberships', [MembershipController::class, 'index'])->name('memberships.index');

// 2. Auth Redirection
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 3. User Routes (Namespace App\Http\Controllers\User)
Route::middleware(['auth', 'verified', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');
    
    // Profile Management
    Route::get('/profile', [App\Http\Controllers\User\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [App\Http\Controllers\User\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\User\ProfileController::class, 'updatePassword'])->name('profile.password');

    // Court Booking
    Route::post('/bookings/store', [App\Http\Controllers\User\BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}/payment', [App\Http\Controllers\User\BookingController::class, 'paymentForm'])->name('bookings.payment');
    Route::post('/bookings/{booking}/payment/upload', [App\Http\Controllers\User\BookingController::class, 'uploadPayment'])->name('bookings.payment.upload');
    Route::post('/bookings/{booking}/cancel', [App\Http\Controllers\User\BookingController::class, 'cancel'])->name('bookings.cancel');

    // Memberships
    Route::post('/memberships/{membership}/purchase', [App\Http\Controllers\User\MembershipController::class, 'purchase'])->name('memberships.purchase');

    // Tournaments
    Route::post('/tournaments/{tournament}/register', [App\Http\Controllers\User\TournamentController::class, 'register'])->name('tournaments.register');

    // Reviews
    Route::post('/courts/{court}/reviews', [App\Http\Controllers\User\ReviewController::class, 'store'])->name('reviews.store');
});

// 4. Admin Routes (Namespace App\Http\Controllers\Admin)
Route::middleware(['auth', 'verified', 'role:admin,super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Court Management CRUD
    Route::get('/courts', [App\Http\Controllers\Admin\CourtController::class, 'index'])->name('courts.index');
    Route::get('/courts/create', [App\Http\Controllers\Admin\CourtController::class, 'create'])->name('courts.create');
    Route::post('/courts/store', [App\Http\Controllers\Admin\CourtController::class, 'store'])->name('courts.store');
    Route::get('/courts/{court}/edit', [App\Http\Controllers\Admin\CourtController::class, 'edit'])->name('courts.edit');
    Route::post('/courts/{court}/update', [App\Http\Controllers\Admin\CourtController::class, 'update'])->name('courts.update');
    Route::delete('/courts/{court}/destroy', [App\Http\Controllers\Admin\CourtController::class, 'destroy'])->name('courts.destroy');

    // Booking & Payment Management
    Route::get('/bookings', [App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [App\Http\Controllers\Admin\BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/approve', [App\Http\Controllers\Admin\BookingController::class, 'approvePayment'])->name('bookings.approve');
    Route::post('/bookings/{booking}/reject', [App\Http\Controllers\Admin\BookingController::class, 'rejectPayment'])->name('bookings.reject');

    // Tournament Management CRUD
    Route::get('/tournaments', [App\Http\Controllers\Admin\TournamentController::class, 'index'])->name('tournaments.index');
    Route::get('/tournaments/create', [App\Http\Controllers\Admin\TournamentController::class, 'create'])->name('tournaments.create');
    Route::post('/tournaments/store', [App\Http\Controllers\Admin\TournamentController::class, 'store'])->name('tournaments.store');
    Route::get('/tournaments/{tournament}/edit', [App\Http\Controllers\Admin\TournamentController::class, 'edit'])->name('tournaments.edit');
    Route::post('/tournaments/{tournament}/update', [App\Http\Controllers\Admin\TournamentController::class, 'update'])->name('tournaments.update');
    Route::delete('/tournaments/{tournament}/destroy', [App\Http\Controllers\Admin\TournamentController::class, 'destroy'])->name('tournaments.destroy');

    // Membership Plan & Subscribers Management
    Route::get('/memberships', [App\Http\Controllers\Admin\MembershipController::class, 'index'])->name('memberships.index');
    Route::get('/memberships/subscribers', [App\Http\Controllers\Admin\MembershipController::class, 'subscribers'])->name('memberships.subscribers');
    Route::get('/memberships/{membership}/edit', [App\Http\Controllers\Admin\MembershipController::class, 'edit'])->name('memberships.edit');
    Route::post('/memberships/{membership}/update', [App\Http\Controllers\Admin\MembershipController::class, 'update'])->name('memberships.update');
});

// 5. Standard Profile Routes for Breeze compatibility
Route::middleware('auth')->group(function () {
    Route::get('/profile', [App\Http\Controllers\User\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\User\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\User\ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
