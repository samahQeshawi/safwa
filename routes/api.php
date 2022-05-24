<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'users',
], function () {
    Route::get('/', 'Api\UsersController@index')
         ->name('api.users.user.index');
    Route::get('/show/{user}','Api\UsersController@show')
         ->name('api.users.user.show');
    Route::post('/', 'Api\UsersController@store')
         ->name('api.users.user.store');
    Route::put('user/{user}', 'Api\UsersController@update')
         ->name('api.users.user.update');
    Route::delete('/user/{user}','Api\UsersController@destroy')
         ->name('api.users.user.destroy');
}); */

Route::post('/register', 'Api\AuthController@register')->name('register.api');
Route::post('/login', 'Api\AuthController@login')->name('login.api');
Route::post('/verify_otp', 'Api\AuthController@verify_otp');

Route::post('/driver_register', 'Api\DriversController@register');
Route::post('/driver_login', 'Api\DriversController@login');
Route::post('/verify_register_otp', 'Api\AuthController@verify_register_otp');

Route::post('/forgot_password', 'Api\AuthController@send_otp');
Route::post('/resend_otp', 'Api\AuthController@resend_otp');
Route::post('/reset_password', 'Api\AuthController@reset_password');

// public
Route::post('/get_cities', 'Api\CitiesController@getCities');
Route::get('/privacy', 'Api\PagesController@privacy');
Route::get('/terms', 'Api\PagesController@terms');


Route::post('/get_category_by_service', 'Api\CustomersTripsController@getCategory');
Route::get('/top_cars', 'Api\CarsController@topcars');
Route::post('/rental_cars_by_branch', 'Api\CarsController@rentalCarsByBranch');
Route::post('/nearest_branches', 'Api\BranchesController@nearestBranches');

Route::apiResource('/cities', 'Api\CitiesController')->withoutMiddleware(['auth:api']);
Route::apiResource('/countries', 'Api\CountriesController')->withoutMiddleware(['auth:api']);
Route::apiResource('/branches', 'Api\BranchesController');
Route::apiResource('/cars', 'Api\CarsController');
Route::get('/rental_cars', 'Api\CarsController@rentalCars');
Route::get('/rental_car_categories', 'Api\CarsController@rentalCarCategories');
Route::post('/rental_cars_by_nearest', 'Api\CarsController@rentalCarsByNearestBranch');

Route::get('/car_rent_bill/pdf/{id}', 'Api\CarRentalsController@carRentBillPdf')->withoutMiddleware(['auth:api']);


/*
Route::middleware(['app_type'])->prefix('driver')->group(function (){
    Route::get('test', function () {
        dd($request->all());
    });
}); */
Route::middleware(['auth:api'])->group(function () {
    Route::get('/logout', 'Api\AuthController@logout');
    Route::get('/list_online_users', 'Api\AuthController@listOnlineUsers');

    Route::post('/sendNotification', 'Api\AuthController@sendNotification');


    //Route::post('/car_rentals', 'Api\CarRentalsController@');
    Route::apiResource('/customers', 'Api\CustomersController');
    Route::apiResource('/payment_method', 'Api\PaymentMethodsController');
    Route::apiResource('/favorite_places', 'Api\FavoritePlacesController');
    Route::post('/delete_favorite_place', 'Api\FavoritePlacesController@delete_favorite_place');
    Route::post('/get_direction', 'Api\FavoritePlacesController@directions');
    Route::apiResource('/coupons', 'Api\CouponsController');
    Route::apiResource('/drivers', 'Api\DriversController');
    Route::post('/update_driver_status', 'Api\DriversController@update_available_status');
    Route::post('/update_driver_details', 'Api\DriversController@update_driver_details');
    Route::get('/driver_details', 'Api\DriversController@driver_details');
    Route::get('/customer_details', 'Api\CustomersController@customer_details');
    Route::post('/update_customer_details', 'Api\CustomersController@update_customer_details');

    //Live driver location update using event broadcasting with webscoket
    Route::post('/update_driver_location', 'Api\DriversController@update_location');

    Route::post('/cancelled_job', 'Api\DriversController@cancelled_job');
    Route::post('/accept_job', 'Api\DriversController@accept_job');
    //Route::post('/update_trip_status', 'Api\DriversController@update_trip_status');
    Route::post('/collect_money', 'Api\DriversController@collect_money');
    Route::post('/driver_ratings', 'Api\DriversController@driver_ratings');
    Route::post('/customer_ratings', 'Api\DriversController@customer_ratings');
    //Route::post('/current_job', 'Api\DriversController@getCurrentJob');
    Route::post('/apply_coupon', 'Api\CouponsController@apply_coupon');
    Route::post('/update_profile_image', 'Api\CustomersController@update_profile_image');
    Route::post('/update_email', 'Api\AuthController@update_email');
    Route::post('/update_phone', 'Api\AuthController@update_phone');
    Route::get('/my_wallet', 'Api\WalletsController@my_wallet');
    Route::get('/wallet_history', 'Api\WalletsController@wallet_history');
    Route::apiResource('/ratings', 'Api\RatingsController');
    Route::apiResource('/rental_car_bookings', 'Api\CarRentalsController');
    Route::post('/my_rent_list', 'Api\CarRentalsController@myRentList');
    Route::post('/my_bill_list', 'Api\CarRentalsController@myBillList');
    Route::post('/my_rides', 'Api\CustomersTripsController@myRidesList');
    Route::get('/get_services', 'Api\CustomersTripsController@getServices');

    Route::post('/create_trip', 'Api\CustomersTripsController@addTripDetails');
    //Route::post('/update_customer_trip_status', 'Api\CustomersTripsController@UpdateTripStatus');
    Route::post('/update_trip_status', 'Api\CustomersTripsController@UpdateTripStatus');
    //Route::post('/update_driver_trip_status', 'Api\DriverTripsController@UpdateTripStatus');
    Route::get('/user_payment_options', 'Api\PaymentMethodsController@user_payment_options');
    Route::post('/add_payment_options', 'Api\PaymentMethodsController@add_payment_options');
    Route::post('/update_payment_default_options', 'Api\PaymentMethodsController@update_payment_default_options');
    Route::get('/my_current_trip', 'Api\CustomersTripsController@my_current_trip');
    Route::post('/update_customer_cancellation_trip_notes', 'Api\CustomersTripsController@update_customer_cancellation_trip_notes');
    Route::post('/update_driver_cancellation_trip_notes', 'Api\DriverTripsController@update_driver_cancellation_trip_notes');
    Route::post('/my_rides_driver', 'Api\DriverTripsController@myRidesList');
    Route::post('/add_user_device', 'Api\UserDeviceController@add_user_device');
    Route::post('/user_trip_apply_coupon', 'Api\CustomersTripsController@applyCoupon');
    Route::post('/user_trip_applied_coupon_details', 'Api\CustomersTripsController@appliedCouponDetails');
    Route::post('/user_trip_remove_coupon', 'Api\CustomersTripsController@removeCoupon');
    Route::post('/add_user_coupon', 'Api\UsersController@addCoupon');
    Route::post('/remove_user_coupon', 'Api\UsersController@removeCoupon');
    Route::get('/user_coupon_details', 'Api\UsersController@getAddedCouponDetails');
    Route::get('/offers', 'Api\CouponsController@offers');
    Route::post('/trip_payment_history', 'Api\CustomersTripsController@myTripsPaymentHistory');
    Route::apiResource('/reporting', 'Api\ComplaintsController');
    Route::post('/online_hours', 'Api\DriversController@onlineHours');

    //Route::post('/users/language', 'Api\UsersController@language')->name('users.language');

    Route::post('/customer_nearest_drivers', 'Api\CustomersTripsController@customer_nearest_drivers');
    // Route::post('/push_nearest_drivers', 'Api\CustomersTripsController@push_nearest_drivers');

    Route::post('/get_chat_by_trip', 'Api\CustomersTripsController@get_chat_by_trip');


    Route::post('get_payment_token', 'Api\PaymentController@get_payment_token');
    Route::post('get_payment_status', 'Api\PaymentController@get_payment_status');
    Route::get('get_registration_token', 'Api\PaymentController@get_registration_token');

    Route::post('save_registration_token', 'Api\PaymentController@save_registration_token');
    Route::post('auto_payment', 'Api\PaymentController@auto_payment');

    Route::post('get_payment_status_new', 'Api\PaymentController@get_payment_status_only');

    // Route::post('server_to_server', 'Api\PaymentController@initialPayment');

    Route::post('server_to_server', 'Api\PaymentController@registration_payment');

    // Route::post('checkout', 'PaymentController@checkout')->name('checkout');
    // Route::post('payment', 'HyperPayPaymentController@payment')->name('payment');
    // Route::post('payment-status', 'HyperPayPaymentController@paymentStatus')->name('payment-status');
    // Route::get('finalize', 'HyperPayPaymentController@finalize')->name('finalize');

    // Route::get('payment/{id}', 'HyperPayPaymentController@show')->name('payment');

    // for test
    Route::post('current_trips', 'TripsController@getCurrentTrips');

    Route::post('import_drivers', 'Api\DriversController@import_drivers');

    Route::post('add_card_wallet', 'Api\AuthController@add_card_wallet');


});


