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
use App\Http\Controllers\Admin\UserController; // <-- Add this use statement at the top


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





    // Add this line for managing users
    Route::resource('users', UserController::class);



    Route::resource('agencies', AgencieController::class);
    Route::resource('bookings', BookingController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('cars', CarController::class);
    Route::resource('car_images', CarImageController::class);
    Route::resource('car_spefications', CarSpeficationController::class);
    Route::resource('car_types', CarTypeController::class);
    Route::resource('fuel_types', FuelTypeController::class);
    Route::resource('insurances', InsuranceController::class);
    Route::resource('mode_payments', ModePaymentController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('promotions', PromotionController::class);
    Route::resource('reviews', ReviewController::class);
    Route::resource('specifications', SpecificationController::class);
});

require __DIR__.'/auth.php';
