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
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CarDeliveryLocationController;
use App\Http\Controllers\CarFeatureController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\client\HomeController;
use App\Http\Controllers\FeatureController;
use App\Models\BookingSpecification;
use App\Models\CarFeature;

// ======= Client Routes =======


Route::get('/', [HomeController::class, 'index'])->name('dashboard');
Route::get('/abouts', function () {
    return view('client.abouts.abouts');
})->middleware(['auth', 'verified'])->name('abouts');


Route::get('/car-listing', [HomeController::class, 'carListing'])->name('cars.listing');
Route::get('/car-detail/{id}', [HomeController::class, 'carDetail'])->name('cars.detail');

// Add the route for fetching agency cities
Route::get('/agencies/cities', [AgencieController::class, 'getCities'])->name('agencies.cities');

// ======= Profile Routes =======
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ======= Admin Routes =======
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.layouts.app');
    })->name('admin');

    Route::resource('users', UserController::class);
    Route::resource('agencies', AgencieController::class);
    Route::resource('bookings', BookingController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('cars', CarController::class);
    Route::resource('car_images', CarImageController::class);
    Route::resource('car_features', CarFeatureController::class);
    Route::resource('car_types', CarTypeController::class);
    Route::resource('fuel_types', FuelTypeController::class);
    Route::resource('insurances', InsuranceController::class);
    Route::resource('mode_payments', ModePaymentController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('promotions', PromotionController::class);
    Route::resource('reviews', ReviewController::class);
    Route::resource('features', FeatureController::class);
    Route::resource('locations',LocationController::class);
    route::resource('specifications', SpecificationController::class);
    // Route::resource('booking_specifications', BookingSpecification::class);
    Route::resource('car_delivery_locations',CarDeliveryLocationController::class);



    Route::get('/car-images/by-car/{car}', [CarImageController::class, 'showByCar'])->name('car_images.by_car');

});

require __DIR__.'/auth.php';
