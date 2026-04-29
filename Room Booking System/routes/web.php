<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =======================
// HOMEPAGE
// =======================
Route::get('/', function () {
    return view('homepage');
})->name('home');


// =======================
// BOOKING (USER)
// =======================
Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

// Autofill IC
Route::get('/autofill', [BookingController::class, 'autofill']);

// Calendar events
Route::get('/booking-events', [BookingController::class, 'events']);

// Check ticket
Route::get('/check-ticket/{ticket_no}', [BookingController::class, 'checkTicket']);


// =======================
// USER LOGIN (optional kalau guna)
// =======================
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.process');


// =======================
// ADMIN LOGIN
// =======================
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
// Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');


// =======================
// ADMIN DASHBOARD (PROTECTED)
// =======================
Route::middleware(['auth'])->prefix('admin')->group(function () {

    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.home');

    Route::post('/approve/{id}', [AdminController::class, 'approve'])->name('admin.approve');
    Route::post('/reject/{id}', [AdminController::class, 'reject'])->name('admin.reject');

    // ✅ REPORT (LETak dalam group ni lagi kemas)
    Route::get('/report', [AdminController::class, 'report'])->name('admin.report');
    Route::get('/report/pdf', [AdminController::class, 'reportPdf'])->name('admin.report.pdf');
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::get('/admin/report', [App\Http\Controllers\AdminController::class, 'report'])->name('admin.report');

// Route::get('/admin/report/pdf', [BookingController::class, 'reportPdf'])->name('admin.report.pdf');

Route::get('/admin/report/pdf', [AdminController::class, 'reportPdf'])->name('admin.report.pdf');

Route::get('/admin/booking/{id}/approve', [BookingController::class, 'approve']);
Route::get('/admin/booking/{id}/reject', [BookingController::class, 'reject']);

// =======================
// ICT DASHBOARD
// =======================

Route::get('/ict/dashboard', [App\Http\Controllers\ICTController::class, 'index'])->name('ict.dashboard');

Route::get('/ict/events', [App\Http\Controllers\ICTController::class, 'events']);
Route::post('/ict/store', [App\Http\Controllers\ICTController::class, 'store']);
Route::post('/ict/delete/{id}', [App\Http\Controllers\ICTController::class, 'delete']);
// Route::post('/ict/store', [ICTController::class, 'store']);