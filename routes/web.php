<?php

use App\Http\Controllers\AgencieController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CarImageController;
use App\Http\Controllers\CarSpeficationController;
use App\Http\Controllers\CarTypeController;
use App\Http\Controllers\FuelTypeController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\ModePaymentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SpecificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// // ======= Admin routes =======
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.layouts.app');
    })->name('admin');

    Route::resource('agencie', AgencieController::class);
    Route::resource('booking', BookingController::class);
    Route::resource('brand', BrandController::class);
    Route::resource('car', CarController::class);
    Route::resource('car_image', CarImageController::class);
    Route::resource('car_spefication', CarSpeficationController::class);
    Route::resource('car_type', CarTypeController::class);
    Route::resource('fuel_type', FuelTypeController::class);
    Route::resource('insurance', InsuranceController::class);
    Route::resource('mode_payment', ModePaymentController::class);
    Route::resource('payment', PaymentController::class);
    Route::resource('promotion', PromotionController::class);
    Route::resource('review', ReviewController::class);
    Route::resource('specification', SpecificationController::class);
});

require __DIR__.'/auth.php';
