<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TreasurerController;
use App\Http\Controllers\EncoderController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login',  [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Treasurer routes
Route::middleware(['auth'])->group(function () {
    Route::get('/treasurer/dashboard',              [TreasurerController::class, 'dashboard'])->name('treasurer');
    Route::get('/treasurer/addfundexpenses',        [TreasurerController::class, 'addFundExpenses'])->name('treasurer.addfundexpenses');
    Route::get('/treasurer/finance',                [TreasurerController::class, 'finance'])->name('treasurer.finance');
    Route::post('/treasurer/addfundexpenses',       [TreasurerController::class, 'store'])->name('treasurer.addfundexpenses.store');
    Route::get('/treasurer/finance/{id}/edit',      [TreasurerController::class, 'edit'])->name('treasurer.edit');
    Route::put('/treasurer/finance/{id}',           [TreasurerController::class, 'update'])->name('treasurer.update');
    Route::delete('/treasurer/finance/{id}',        [TreasurerController::class, 'destroy'])->name('treasurer.destroy');
    Route::patch('/treasurer/finance/{id}/approve', [TreasurerController::class, 'approve'])->name('treasurer.approve');
    Route::patch('/treasurer/finance/{id}/reject',  [TreasurerController::class, 'reject'])->name('treasurer.reject');
    Route::get('/treasurer/transactions',           [TreasurerController::class, 'transactions'])->name('treasurer.transactions');
    Route::get('/treasurer/reports',                [TreasurerController::class, 'reports'])->name('treasurer.reports');
});

// Encoder routes
Route::middleware(['auth'])->group(function () {
    Route::get('/encoder/finance',      [EncoderController::class, 'finance'])->name('encoder.finance');
    Route::post('/encoder/finance',     [EncoderController::class, 'store'])->name('encoder.finance.store');
    Route::get('/encoder/transactions', [EncoderController::class, 'transactions'])->name('encoder.transactions');
});

// Admin routes
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard',        [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/accounts',        [AdminController::class, 'store'])->name('admin.accounts.store');
    Route::put('/admin/accounts/{id}',    [AdminController::class, 'update'])->name('admin.accounts.update');
    Route::delete('/admin/accounts/{id}', [AdminController::class, 'destroy'])->name('admin.accounts.destroy');
});