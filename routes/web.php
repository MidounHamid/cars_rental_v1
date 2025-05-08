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
use App\Http\Controllers\StripePaymentController;
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



//this route is for the stripe payment
Route::get('/payment', [StripePaymentController::class, 'index'])->name('stripe.payment');
Route::post('/checkout', [StripePaymentController::class, 'checkout'])->name('stripe.checkout');
Route::post('/confirm-payment', [StripePaymentController::class, 'confirmPayment'])->name('stripe.confirm');
Route::get('/stripe/success', [StripePaymentController::class, 'success'])->name('stripe.success');
Route::get('/stripe/cancel', [StripePaymentController::class, 'cancel'])->name('stripe.cancel');






// Add the route for fetching agency cities
Route::get('/agencies/cities', [AgencieController::class, 'getCities'])->name('agencies.cities');

// ======= Profile Routes =======
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/reservations', [ProfileController::class, 'reservations'])->name('profile.reservations');
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
    Route::resource('locations', LocationController::class);
    route::resource('specifications', SpecificationController::class);
    // Route::resource('booking_specifications', BookingSpecification::class);
    Route::resource('car_delivery_locations', CarDeliveryLocationController::class);



    Route::get('/car-images/by-car/{car}', [CarImageController::class, 'showByCar'])->name('car_images.by_car');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Notification routes
    Route::get('/notifications', [App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{notification}', [App\Http\Controllers\Admin\NotificationController::class, 'show'])->name('notifications.show');
    Route::post('/notifications/{notification}/mark-as-read', [App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::post('/notifications/mark-all-as-read', [App\Http\Controllers\Admin\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');
    Route::get('/notifications/unread-count', [App\Http\Controllers\Admin\NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::get('/notifications/recent', [App\Http\Controllers\Admin\NotificationController::class, 'getRecent'])->name('notifications.recent');
});

require __DIR__ . '/auth.php';
