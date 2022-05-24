<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('lang/{locale}', 'HomeController@lang');

// redirect main page
Route::get('/', 'WebsiteController@index')->name('web.home');
// Route::get('/', function () {
//     return redirect()->route('home');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::get('/real-time-messaging/{token}', 'Api\AuthController@msgForm');

//Route::get('/email', 'EmailsController@index')->name('email');
/*
Route::get('send-mail', function () {

    $email = ['message' => 'This is a test!'];
    \Mail::to('anishkmathew@gmail.com')->send(new \App\Mail\TestEmail($email));

    dd("Email is Sent.");
}); */
//Route::get("send-email", 'EmailController@sendEmail')->name('first.email');
Route::group([
    'middleware' => ['permission:view users'],
    'prefix' => 'users',
], function () {
    Route::get('/', 'UsersController@index')
        ->name('users.user.index');
    Route::get('/create', 'UsersController@create')
        ->name('users.user.create');
    Route::get('/show/{user}', 'UsersController@show')
        ->name('users.user.show');
    Route::get('/{user}/edit', 'UsersController@edit')
        ->name('users.user.edit');
    Route::post('/', 'UsersController@store')
        ->name('users.user.store');
    Route::put('user/{user}', 'UsersController@update')
        ->name('users.user.update');
    Route::delete('/user/{user}', 'UsersController@destroy')
        ->name('users.user.destroy');
});

Route::group([
    'prefix' => 'companies',
], function () {
    Route::get('/', 'CompaniesController@index')
        ->name('companies.company.index')->middleware("can:view companies");
    Route::get('/create', 'CompaniesController@create')
        ->name('companies.company.create')->middleware("can:add companies");
    Route::get('/show/{company}', 'CompaniesController@show')
        ->name('companies.company.show')->middleware("can:view companies");
    Route::get('/{company}/edit', 'CompaniesController@edit')
        ->name('companies.company.edit')->middleware("can:edit companies");
    Route::post('/', 'CompaniesController@store')
        ->name('companies.company.store')->middleware("can:add companies");
    Route::put('company/{company}', 'CompaniesController@update')
        ->name('companies.company.update')->middleware("can:edit companies");
    Route::delete('/company/{company}', 'CompaniesController@destroy')
        ->name('companies.company.destroy')->middleware("can:delete companies");});

Route::group([
    'middleware' => ['permission:view ratings'],
    'prefix' => 'ratings',
], function () {
    Route::get('/', 'RatingsController@index')
        ->name('rating.index')->middleware("can:view ratings");

    Route::get('/show/{company}', 'RatingsController@show')
        ->name('rating.show')->middleware("can:view ratings");
    Route::get('/{rating}/edit', 'RatingsController@edit')
        ->name('rating.edit')->middleware("can:edit ratings");
    Route::put('rating/{rating}', 'RatingsController@update')
        ->name('rating.update')->middleware("can:edit ratings");
    Route::delete('/rating/{rating}', 'RatingsController@destroy')
        ->name('rating.destroy')->middleware("can:delete ratings");});

Route::group([
    'middleware' => ['permission:view stores'],
    'prefix' => 'stores',
], function () {
    Route::get('/', 'StoresController@index')
        ->name('stores.store.index');
    Route::get('/create', 'StoresController@create')
        ->name('stores.store.create');
    Route::get('/show/{store}', 'StoresController@show')
        ->name('stores.store.show');
    Route::get('/{store}/edit', 'StoresController@edit')
        ->name('stores.store.edit');
    Route::post('/', 'StoresController@store')
        ->name('stores.store.store');
    Route::put('store/{store}', 'StoresController@update')
        ->name('stores.store.update');
    Route::delete('/store/{store}', 'StoresController@destroy')
        ->name('stores.store.destroy');
});
Route::group([
    'prefix' => 'coupons',
], function () {
    Route::get('/', 'CouponsController@index')
        ->name('coupon.index')->middleware('can:view promo_codes');
    Route::get('/create', 'CouponsController@create')
        ->name('coupon.create')->middleware('can:add promo_codes');
    Route::get('/show/{coupon}', 'CouponsController@show')
        ->name('coupon.show')->middleware('can:view promo_codes');
    Route::get('/{store}/edit', 'CouponsController@edit')
        ->name('coupon.edit')->middleware('can:edit promo_codes');
    Route::post('/', 'CouponsController@store')
        ->name('coupon.store')->middleware('can:create promo_codes');
    Route::put('coupon/{coupon}', 'CouponsController@update')
        ->name('coupon.update')->middleware('can:edit promo_codes');
    Route::delete('/coupon/{coupon}', 'CouponsController@destroy')
        ->name('coupon.destroy')->middleware('can:delete promo_codes');});
/* Route::group([
    'prefix' => 'categories',
], function () {
    Route::get('/', 'CategoriesController@index')
        ->name('categories.categories.index');
    Route::get('/create', 'CategoriesController@create')
        ->name('categories.categories.create');
    Route::get('/show/{categories}', 'CategoriesController@show')
        ->name('categories.categories.show')->where('id', '[0-9]+');
    Route::get('/{categories}/edit', 'CategoriesController@edit')
        ->name('categories.categories.edit')->where('id', '[0-9]+');
    Route::post('/', 'CategoriesController@store')
        ->name('categories.categories.store');
    Route::put('categories/{categories}', 'CategoriesController@update')
        ->name('categories.categories.update')->where('id', '[0-9]+');
    Route::delete('/categories/{categories}', 'CategoriesController@destroy')
        ->name('categories.categories.destroy')->where('id', '[0-9]+');
}); */
Route::group([
    'prefix' => 'notification',
], function () {
    Route::get('/', 'NotificationController@index')
        ->name('notification.index')->middleware('can:view notifications');
    Route::get('/create', 'NotificationController@create')
        ->name('notification.create')->middleware('can:add notifications');
    Route::get('/show/{notification}', 'NotificationController@show')
        ->name('notification.show')->where('id', '[0-9]+')->middleware('can:view notifications');
    Route::get('/{notification}/edit', 'NotificationController@edit')
        ->name('notification.edit')->where('id', '[0-9]+')->middleware('can:edit notifications');
    Route::post('/', 'NotificationController@store')
        ->name('notification.store')->middleware('can:add notifications');
    Route::put('notification/{notification}', 'NotificationController@update')
        ->name('notification.update')->where('id', '[0-9]+')->middleware('can:edit notifications');
    Route::delete('/notification/{notification}', 'NotificationController@destroy')
        ->name('notification.destroy')->where('id', '[0-9]+')->middleware('can:delete notifications');
    Route::get('/send/{notification}', 'NotificationController@send')
        ->name('notification.send');
    Route::post('/send_notification', 'NotificationController@send_notification')
        ->name('notification.send_notification');
    Route::get('/search_user', 'NotificationController@getUser')
        ->name('notification.search.user');
});

Route::group([
    'prefix' => 'cartypes',
], function () {
    Route::get('/', 'CarTypesController@index')
        ->name('cartype.index')->middleware('can:view setting');
    Route::get('/create', 'CarTypesController@create')
        ->name('cartype.create')->middleware('can:add setting');
    Route::get('/show/{cartype}', 'CarTypesController@show')
        ->name('cartype.show')->where('id', '[0-9]+')->middleware('can:view setting');
    Route::get('/{cartype}/edit', 'CarTypesController@edit')
        ->name('cartype.edit')->where('id', '[0-9]+')->middleware('can:edit setting');
    Route::post('/', 'CarTypesController@store')
        ->name('cartype.store')->middleware('can:add setting');
    Route::put('cartype/{cartype}', 'CarTypesController@update')
        ->name('cartype.update')->where('id', '[0-9]+')->middleware('can:edit setting');
    Route::delete('/cartype/{cartype}', 'CarTypesController@destroy')
        ->name('cartype.destroy')->where('id', '[0-9]+')->middleware('can:delete setting');
});

Route::group([
    'prefix' => 'complaints',
], function () {
    Route::get('/', 'ComplaintsController@index')
        ->name('complaint.index');
    Route::get('/show/{complaint}', 'ComplaintsController@show')
        ->name('complaint.show')->where('id', '[0-9]+');
    Route::delete('/complaint/{complaint}', 'ComplaintsController@destroy')
        ->name('complaint.destroy')->where('id', '[0-9]+');
    Route::post('/change_status', 'ComplaintsController@change_status')
        ->name('complaint.change_status');
});

Route::group([
    'prefix' => 'transactions',
], function () {
    Route::get('/', 'TransactionsController@index')
        ->name('transaction.index')->middleware('can:view wallet');
    Route::get('/create', 'TransactionsController@create')
        ->name('transaction.create')->middleware('can:add wallet');
    Route::get('/show/{transaction}', 'TransactionsController@show')
        ->name('transaction.show')->where('id', '[0-9]+')->middleware('can:add wallet');
    Route::get('/{transaction}/edit', 'TransactionsController@edit')
        ->name('transaction.edit')->where('id', '[0-9]+')->middleware('can:edit wallet');
    Route::post('/', 'TransactionsController@store')
        ->name('transaction.store')->middleware('can:add wallet');
    Route::put('transaction/{transaction}', 'TransactionsController@update')
        ->name('transaction.update')->where('id', '[0-9]+')->middleware('can:edit wallet');
    Route::delete('/transaction/{transaction}', 'TransactionsController@destroy')
        ->name('transaction.destroy')->where('id', '[0-9]+')->middleware('can:delete wallet');
    Route::get('/search_booking', 'TransactionsController@getBooking')
        ->name('transaction.search.booking');
    Route::get('/search_trip', 'TransactionsController@getTrip')
        ->name('transaction.search.trip');
    Route::get('/search_receiver', 'TransactionsController@getReceiver')
        ->name('transaction.search.receiver');
    Route::get('/search_sender', 'TransactionsController@getSender')
        ->name('transaction.search.sender');
    Route::post('/booking_request', 'TransactionsController@getBookingRequest')
        ->name('transaction.booking.request');
});
Route::group([
    'prefix' => 'coupon_reports',
], function () {
    Route::get('/', 'CouponReportsController@index')
        ->name('coupon_reports.index');
    Route::get('/show/{coupon_report}', 'CouponReportsController@show')
        ->name('coupon_reports.show');
    Route::get('/coupon_report/{code}', 'CouponReportsController@view_coupons')
        ->name('coupon_reports.view_coupons');
});
Route::group([
    'prefix' => 'wallets',
], function () {
    Route::get('/', 'WalletsController@index')
        ->name('wallet.index')->middleware('can:view wallet');
    Route::get('/wallet_type/{user_type}', 'WalletsController@index')
        ->name('wallet.driver')->middleware('can:view wallet');
    Route::get('/create', 'WalletsController@create')
        ->name('wallet.create')->middleware('can:add wallet');
    Route::get('/show/{wallet}', 'WalletsController@show')
        ->name('wallet.show')->where('id', '[0-9]+');
    Route::post('/add_wallet_amount', 'WalletsController@addWalletAmount')
        ->name('wallet.amount')->middleware('can:edit wallet');
    Route::post('/subtract_wallet_amount', 'WalletsController@subtractWalletAmount')
        ->name('wallet.subract.amount')->middleware('can:edit wallet');
});
Route::group([
    'prefix' => 'setting',
], function () {
    Route::get('/general', 'SettingController@general')
        ->name('setting.general');
    Route::post('/general', 'SettingController@general')
        ->name('setting.general.store');
});
Route::group([
    'prefix' => 'sms',
], function () {
    Route::get('/', 'SmsController@index')
        ->name('sms.index');
    Route::post('/', 'SmsController@send')
        ->name('sms.send');
});
Route::group([
    'prefix' => 'paymentmethods',
], function () {
    Route::get('/', 'PaymentMethodsController@index')
        ->name('paymentmethod.index')->middleware('can:view setting');

    Route::get('/create', 'PaymentMethodsController@create')
        ->name('paymentmethod.create')->middleware('can:add setting');
    Route::get('/show/{paymentmethod}', 'PaymentMethodsController@show')
        ->name('paymentmethod.show')->where('id', '[0-9]+')->middleware('can:view setting');
    Route::get('/{paymentmethod}/edit', 'PaymentMethodsController@edit')
        ->name('paymentmethod.edit')->where('id', '[0-9]+')->middleware('can:edit setting');
    Route::post('/', 'PaymentMethodsController@store')
        ->name('paymentmethod.store')->middleware('can:add setting');
    Route::put('paymentmethod/{paymentmethod}', 'PaymentMethodsController@update')
        ->name('paymentmethod.update')->where('id', '[0-9]+')->middleware('can:edit setting');
    Route::delete('/paymentmethod/{paymentmethod}', 'PaymentMethodsController@destroy')
        ->name('paymentmethod.destroy')->where('id', '[0-9]+')->middleware('can:delete setting');
});
Route::group([
    'prefix' => 'carmakes',
], function () {
    Route::get('/', 'CarMakesController@index')
        ->name('make.index')->middleware('can:view setting');
    Route::get('/create', 'CarMakesController@create')
        ->name('make.create')->middleware('can:add setting');
    Route::get('/show/{carmake}', 'CarMakesController@show')
        ->name('make.show')->where('id', '[0-9]+')->middleware('can:view setting');
    Route::get('/{carmake}/edit', 'CarMakesController@edit')
        ->name('make.edit')->where('id', '[0-9]+')->middleware('can:edit setting');
    Route::post('/', 'CarMakesController@store')
        ->name('make.store')->middleware('can:add setting');
    Route::put('carmake/{carmake}', 'CarMakesController@update')
        ->name('make.update')->where('id', '[0-9]+')->middleware('can:edit setting');
    Route::delete('/carmake/{carmake}', 'CarMakesController@destroy')
        ->name('make.destroy')->where('id', '[0-9]+')->middleware('can:delete setting');
});
Route::group([
    'prefix' => 'permission',
], function () {
    Route::get('/', 'PermissionController@index')
        ->name('permission.index')->middleware('can:view user_manage');
    Route::get('/create', 'PermissionController@create')
        ->name('permission.create')->middleware('can:add user_manage');
    Route::get('/show/{permission}', 'PermissionController@show')
        ->name('permission.show')->where('id', '[0-9]+')->middleware('can:view user_manage');
    Route::get('/{permission}/edit', 'PermissionController@edit')
        ->name('permission.edit')->where('id', '[0-9]+')->middleware('can:edit user_manage');
    Route::post('/', 'PermissionController@store')
        ->name('permission.store')->middleware('can:add user_manage');
    Route::put('permission/{carmake}', 'PermissionController@update')
        ->name('permission.update')->where('id', '[0-9]+')->middleware('can:edit user_manage');
    Route::delete('/permission/{carmake}', 'PermissionController@destroy')
        ->name('permission.destroy')->where('id', '[0-9]+')->middleware('can:delete user_manage');
});
Route::group([
    'prefix' => 'cars',
], function () {
    Route::get('/', 'CarsController@index')
        ->name('car.index')->middleware('can:view cars');
    Route::get('/create', 'CarsController@create')
        ->name('car.create')->middleware('can:add cars');
    Route::get('/show/{car}', 'CarsController@show')
        ->name('car.show')->where('id', '[0-9]+')->middleware('can:view cars');
    Route::get('/{car}/edit', 'CarsController@edit')
        ->name('car.edit')->where('id', '[0-9]+')->middleware('can:edit cars');
    Route::post('/', 'CarsController@store')
        ->name('car.store')->middleware('permission:add cars');
    Route::put('car/{car}', 'CarsController@update')
        ->name('car.update')->where('id', '[0-9]+')->middleware('can:edit cars');
    Route::delete('/car/{car}', 'CarsController@destroy')
        ->name('car.destroy')->where('id', '[0-9]+')->middleware('can:delete cars');
    Route::get('/search_location', 'CarsController@getLocation')
        ->name('car.search.location');
    Route::get('/get_categories', 'CarsController@getCategories')
        ->name('car.getcategories');
    Route::get('/cars_type/{type}', 'CarsController@view_cars')
        ->name('car.view_cars');
});
Route::group([
    'prefix' => 'user_admin',
], function () {
    Route::get('/', 'AdminController@index')
        ->name('user_admin.index')->middleware('can:view user_manage');
    Route::get('/create', 'AdminController@create')
        ->name('user_admin.create')->middleware('can:add user_manage');
    Route::get('/show/{user_admin}', 'AdminController@show')
        ->name('user_admin.show')->where('id', '[0-9]+')->middleware('can:view user_manage');
    Route::post('/', 'AdminController@store')
        ->name('user_admin.store')->middleware('can:add user_manage');
    Route::get('/{user_admin}/edit', 'AdminController@edit')
        ->name('user_admin.edit')->where('id', '[0-9]+')->middleware('can:edit user_manage');
    Route::put('user_admin/{user_admin}', 'AdminController@update')
        ->name('user_admin.update')->where('id', '[0-9]+')->middleware('can:edit user_manage');
    Route::delete('/user_admin/{user_admin}', 'AdminController@destroy')
        ->name('user_admin.destroy')->where('id', '[0-9]+')->middleware('can:delete user_manage');
});
Route::group([
    'prefix' => 'customers',
], function () {
    Route::get('/', 'CustomersController@index')
        ->name('customer.index')->middleware('can:view customers');
    Route::get('/create', 'CustomersController@create')
        ->name('customer.create')->middleware('can:add customers');
    Route::get('/nearest-drivers/{customer}', 'CustomersController@getNearestDrivers')
        ->name('customers.customer.nearest')->middleware('can:view customers');
    Route::get('/show/{customer}', 'CustomersController@show')
        ->name('customer.show')->where('id', '[0-9]+')->middleware('can:view customers');
    Route::post('/', 'CustomersController@store')
        ->name('customer.store')->middleware('can:add customers');
    Route::get('/{customer}/edit', 'CustomersController@edit')
        ->name('customer.edit')->where('id', '[0-9]+')->middleware('can:edit customers');
    Route::put('customer/{customer}', 'CustomersController@update')
        ->name('customer.update')->where('id', '[0-9]+')->middleware('can:edit customers');
    Route::delete('/customer/{customer}', 'CustomersController@destroy')
        ->name('customer.destroy')->where('id', '[0-9]+')->middleware('can:delete customers');
});
Route::group([
    'prefix' => 'bookings',
], function () {
    Route::get('/', 'BookingsController@index')
        ->name('booking.index');
    Route::get('/create', 'BookingsController@create')
        ->name('booking.create');
    Route::get('/show/{booking}', 'BookingsController@show')
        ->name('booking.show')->where('id', '[0-9]+');
    Route::post('/', 'BookingsController@store')
        ->name('booking.store');
    Route::get('/{booking}/edit', 'BookingsController@edit')
        ->name('booking.edit')->where('id', '[0-9]+');
    Route::put('booking/{booking}', 'BookingsController@update')
        ->name('booking.update')->where('id', '[0-9]+');
    Route::delete('/booking/{booking}', 'BookingsController@destroy')
        ->name('booking.destroy')->where('id', '[0-9]+');
    Route::post('/send-booking-email', 'BookingsController@sendBookingEmail')
        ->name('booking.email')->where('id', '[0-9]+');
    Route::get('/invoice/{booking}', 'BookingsController@showInvoice')
        ->name('bookings.booking.invoice')->where('id', '[0-9]+');
    Route::get('/invoice/print/{booking}', 'BookingsController@printInvoice')
        ->name('bookings.booking.invoice.print')->where('id', '[0-9]+');
    Route::get('/invoice/pdf/{booking}', 'BookingsController@pdfInvoice')
        ->name('bookings.booking.invoice.pdf')->where('id', '[0-9]+');
});

Route::group([
    'prefix' => 'branch',
], function () {
    Route::get('/', 'BranchesController@index')
        ->name('branches.index')->middleware('can:view branch');
    Route::get('/create', 'BranchesController@create')
        ->name('branches.create')->middleware('can:add branch');
    Route::get('/show/{branch}', 'BranchesController@show')
        ->name('branches.show')->where('id', '[0-9]+')->middleware('can:view branch');
    Route::post('/', 'BranchesController@store')
        ->name('branches.store')->middleware('can:add branch');
    Route::get('/{branch}/edit', 'BranchesController@edit')
        ->name('branches.edit')->where('id', '[0-9]+')->middleware('can:edit branch');
    Route::put('branches/{branch}', 'BranchesController@update')
        ->name('branches.update')->where('id', '[0-9]+')->middleware('can:edit branch');
    Route::delete('/branches/{branch}', 'BranchesController@destroy')
        ->name('branches.destroy')->where('id', '[0-9]+')->middleware('can:delete branch');
});
Route::group([
    'prefix' => 'favorite_places',
], function () {
    Route::get('/', 'FavoritePlacesController@index')
        ->name('favorite_places.index');
    Route::get('/create', 'FavoritePlacesController@create')
        ->name('favorite_places.create');
    Route::get('/show/{branch}', 'FavoritePlacesController@show')
        ->name('favorite_places.show')->where('id', '[0-9]+');
    Route::post('/', 'FavoritePlacesController@store')
        ->name('favorite_places.store');
    Route::get('/{place}/edit', 'FavoritePlacesController@edit')
        ->name('favorite_places.edit')->where('id', '[0-9]+');
    Route::put('favorite_place/{place}', 'FavoritePlacesController@update')
        ->name('favorite_places.update')->where('id', '[0-9]+');
    Route::delete('/favorite_place/{place}', 'FavoritePlacesController@destroy')
        ->name('favorite_places.destroy')->where('id', '[0-9]+');
    Route::get('/search_user', 'FavoritePlacesController@getUser')
        ->name('favorite_places.search.user');
});
Route::group([
    'prefix' => 'car_rentals',
], function () {
    Route::get('/', 'CarRentalsController@index')
        ->name('car_rentals.index')->middleware('can:view booking');
    Route::get('/create', 'CarRentalsController@create')
        ->name('car_rentals.create')->middleware('can:add booking');
    Route::get('/show/{car_rental}', 'CarRentalsController@show')
        ->name('car_rentals.show')->where('id', '[0-9]+')->middleware('can:view booking');
    Route::post('/', 'CarRentalsController@store')
        ->name('car_rentals.store')->middleware('can:add booking');
    Route::get('/{car_rental}/edit', 'CarRentalsController@edit')
        ->name('car_rentals.edit')->where('id', '[0-9]+')->middleware('can:edit booking');
    Route::put('car_rental/{car_rental}', 'CarRentalsController@update')
        ->name('car_rentals.update')->where('id', '[0-9]+')->middleware('can:edit booking');
    Route::delete('/car_rental/{car_rental}', 'CarRentalsController@destroy')
        ->name('car_rentals.destroy')->where('id', '[0-9]+')->middleware('can:delete booking');    
    Route::get('/invoice/{car_rental}', 'CarRentalsController@showInvoice')
        ->name('car_rentals.car_rental.invoice')->where('id', '[0-9]+');
    Route::get('/invoice/print/{car_rental}', 'CarRentalsController@printInvoice')
        ->name('car_rentals.car_rental.invoice.print')->where('id', '[0-9]+');
    Route::get('/invoice/pdf/{car_rental}', 'CarRentalsController@pdfInvoice')
        ->name('car_rentals.car_rental.invoice.pdf')->where('id', '[0-9]+');

    Route::post('/calculate_car_rent', 'CarRentalsController@calculateCarRentByDate')
        ->name('CarRentals.calculateCarRent');
});

Route::group([
    'prefix' => 'categories',
], function () {
   Route::get('/', 'CategoriesController@index')
        ->name('categories.category.index')->middleware('can:view categories');
    Route::get('/create', 'CategoriesController@create')
        ->name('categories.category.create')->middleware('can:add categories');
    Route::get('/show/{category}', 'CategoriesController@show')
        ->name('categories.category.show')->where('id', '[0-9]+')->middleware('can:view categories');
    Route::get('/{category}/edit', 'CategoriesController@edit')
        ->name('categories.category.edit')->where('id', '[0-9]+')->middleware('can:edit categories');
    Route::post('/', 'CategoriesController@store')
        ->name('categories.category.store')->middleware('can:add categories');
    Route::put('category/{category}', 'CategoriesController@update')
        ->name('categories.category.update')->where('id', '[0-9]+')->middleware('can:edit categories');
    Route::delete('/category/{category}', 'CategoriesController@destroy')
        ->name('categories.category.destroy')->where('id', '[0-9]+')->middleware('can:delete categories');
    Route::get('/category_type/{type}', 'CategoriesController@view_category')
        ->name('categories.category.view_categories')->middleware('can:view categories');
});

Route::group([
    'prefix' => 'countries',
], function () {
    Route::get('/', 'CountriesController@index')
        ->name('countries.country.index')->middleware('can:view setting');
    Route::get('/create', 'CountriesController@create')
        ->name('countries.country.create')->middleware('can:add setting');
    Route::get('/show/{country}', 'CountriesController@show')
        ->name('countries.country.show')->where('id', '[0-9]+')->middleware('can:add setting');
    Route::get('/{country}/edit', 'CountriesController@edit')
        ->name('countries.country.edit')->where('id', '[0-9]+')->middleware('can:edit setting');
    Route::post('/', 'CountriesController@store')
        ->name('countries.country.store')->middleware('can:add setting');
    Route::put('country/{country}', 'CountriesController@update')
        ->name('countries.country.update')->where('id', '[0-9]+')->middleware('can:edit setting');
    Route::delete('/country/{country}', 'CountriesController@destroy')
        ->name('countries.country.destroy')->where('id', '[0-9]+')->middleware('can:delete setting');
});

Route::group([
    'prefix' => 'cities',
], function () {
    Route::get('/', 'CitiesController@index')
        ->name('cities.city.index');
    Route::get('/create', 'CitiesController@create')
        ->name('cities.city.create');
    Route::get('/show/{city}', 'CitiesController@show')
        ->name('cities.city.show')->where('id', '[0-9]+');
    Route::get('/{city}/edit', 'CitiesController@edit')
        ->name('cities.city.edit')->where('id', '[0-9]+');
    Route::post('/', 'CitiesController@store')
        ->name('cities.city.store');
    Route::put('city/{city}', 'CitiesController@update')
        ->name('cities.city.update')->where('id', '[0-9]+');
    Route::delete('/city/{city}', 'CitiesController@destroy')
        ->name('cities.city.destroy')->where('id', '[0-9]+');
});

Route::group([
    'prefix' => 'drivers',
], function () {
   Route::get('/trip-routes/{trip}', 'DriversController@tripRoutes')
        ->name('drivers.trip.routes')->middleware('can:view drivers');
    Route::get('/', 'DriversController@index')
        ->name('drivers.driver.index')->middleware('can:view drivers');
    Route::get('/online-drivers', 'DriversController@onlineDrivers')
        ->name('drivers.driver.online')->middleware('can:view drivers');
    Route::get('/create', 'DriversController@create')
        ->name('drivers.driver.create')->middleware('can:add drivers');
    Route::get('/show/{driver}', 'DriversController@show')
        ->name('drivers.driver.show')->where('id', '[0-9]+')->middleware('can:view drivers');
    Route::get('/{driver}/edit', 'DriversController@edit')
        ->name('drivers.driver.edit')->where('id', '[0-9]+')->middleware('can:edit drivers');
    Route::post('/', 'DriversController@store')
        ->name('drivers.driver.store')->middleware('can:add drivers');
    Route::put('driver/{driver}', 'DriversController@update')
        ->name('drivers.driver.update')->where('id', '[0-9]+')->middleware('can:edit drivers');
    Route::delete('/driver/{driver}', 'DriversController@destroy')
        ->name('drivers.driver.destroy')->where('id', '[0-9]+')->middleware('can:delete drivers');
});

Route::group([
    'prefix' => 'trips',
], function () {
    Route::get('/', 'TripsController@index')
        ->name('trip.index')->middleware('can:view trips');
    Route::get('/trip_type/{trip_type}', 'TripsController@index')
        ->name('trip.now')->middleware('can:view trips');
    Route::get('/create', 'TripsController@create')
        ->name('trip.create')->middleware('can:add trips');
    Route::get('/show/{trip}', 'TripsController@show')
        ->name('trip.show')->where('id', '[0-9]+')->middleware('can:view trips');
    Route::get('/{trip}/edit', 'TripsController@edit')
        ->name('trip.edit')->where('id', '[0-9]+')->middleware('can:edit trips');
    Route::post('/', 'TripsController@store')
        ->name('trip.store')->middleware('can:add trips');
    Route::put('trip/{trip}', 'TripsController@update')
        ->name('trip.update')->where('id', '[0-9]+')->middleware('can:edit trips');
    Route::delete('/trip/{trip}', 'TripsController@destroy')
        ->name('trip.destroy')->where('id', '[0-9]+')->middleware('can:delete trips');
    Route::get('/invoice/{trip}', 'TripsController@showInvoice')
        ->name('trip.invoice')->where('id', '[0-9]+');
    Route::get('/invoice/print/{trip}', 'TripsController@printInvoice')
        ->name('trip.invoice.print')->where('id', '[0-9]+');
    Route::get('/invoice/pdf/{trip}', 'TripsController@pdfInvoice')
        ->name('trip.invoice.pdf')->where('id', '[0-9]+');
    Route::get('/get_categories', 'TripsController@getCategories')
        ->name('trip.getcategories');
});
Route::group([
    'prefix' => 'services',
], function () {
    Route::get('/', 'ServicesController@index')
        ->name('services.service.index');
    Route::get('/create', 'ServicesController@create')
        ->name('services.service.create');
    Route::get('/show/{service}', 'ServicesController@show')
        ->name('services.service.show');
    Route::get('/{service}/edit', 'ServicesController@edit')
        ->name('services.service.edit');
    Route::post('/', 'ServicesController@store')
        ->name('services.service.store');
    Route::put('service/{service}', 'ServicesController@update')
        ->name('services.service.update');
    Route::delete('/service/{service}', 'ServicesController@destroy')
        ->name('services.service.destroy');
});

Route::group([
    'prefix' => 'fuel_types',
], function () {
    Route::get('/', 'FuelTypesController@index')
        ->name('fuel_types.fuel_type.index')->middleware('can:view setting');
    Route::get('/create', 'FuelTypesController@create')
        ->name('fuel_types.fuel_type.create')->middleware('can:add setting');
    Route::get('/show/{fuelType}', 'FuelTypesController@show')
        ->name('fuel_types.fuel_type.show')->middleware('can:view setting');
    Route::get('/{fuelType}/edit', 'FuelTypesController@edit')
        ->name('fuel_types.fuel_type.edit')->middleware('can:edit setting');
    Route::post('/', 'FuelTypesController@store')
        ->name('fuel_types.fuel_type.store')->middleware('can:add setting');
    Route::put('fuel_type/{fuelType}', 'FuelTypesController@update')
        ->name('fuel_types.fuel_type.update')->middleware('can:edit setting');
    Route::delete('/fuel_type/{fuelType}', 'FuelTypesController@destroy')
        ->name('fuel_types.fuel_type.destroy')->middleware('can:delete setting');});


//Exports // Reports
Route::group([
    'middleware' => ['can:view reports'],
    'prefix' => 'reports',
], function () {
    //Users
    Route::get('/', 'ReportsController@exportUsers')
        ->name('users.reports.listing');
    Route::get('users/export/excel', 'ReportsController@excelExportUsers')
        ->name('users.excel.report');
    Route::get('users/export/pdf', 'ReportsController@pdfExportUsers')
        ->name('users.pdf.report');
    Route::get('/trips', 'ReportsController@exportTrips')
        ->name('trips.reports.listing');
    Route::get('trips/export/excel', 'ReportsController@excelExportTrips')
        ->name('trips.excel.report');
    Route::get('trips/export/pdf', 'ReportsController@pdfExportTrips')
        ->name('trips.pdf.report');
    Route::get('/bookings', 'ReportsController@exportBookings')
        ->name('bookings.reports.listing');
    Route::get('bookings/export/excel', 'ReportsController@excelExportBooking')
        ->name('bookings.excel.report');
    Route::get('bookings/export/pdf', 'ReportsController@pdfExportBooking')
        ->name('bookings.pdf.report');
    Route::get('/cars', 'ReportsController@exportCars')
        ->name('cars.reports.listing');
    Route::get('cars/export/excel', 'ReportsController@excelExportCar')
        ->name('cars.excel.report');
    Route::get('cars/export/pdf', 'ReportsController@pdfExportCar')
        ->name('cars.pdf.report');
    Route::get('/wallets', 'ReportsController@exportWallets')
        ->name('wallets.reports.listing');
    Route::get('wallets/export/excel', 'ReportsController@excelExportWallet')
        ->name('wallets.excel.report');
    Route::get('wallets/export/pdf', 'ReportsController@pdfExportWallet')
        ->name('wallets.pdf.report');
    Route::get('/transactions', 'ReportsController@exportTransactions')
        ->name('transactions.reports.listing');
    Route::get('transactions/export/excel', 'ReportsController@excelExportTransaction')
        ->name('transactions.excel.report');
    Route::get('transactions/export/pdf', 'ReportsController@pdfExportTransaction')
        ->name('transactions.pdf.report');
    Route::get('/branches', 'ReportsController@exportBranches')
        ->name('branches.reports.listing');
    Route::get('branches/export/excel', 'ReportsController@excelExportBranch')
        ->name('branches.excel.report');
    Route::get('branches/export/pdf', 'ReportsController@pdfExportBranch')
        ->name('branches.pdf.report');
    Route::get('/coupons', 'ReportsController@exportCoupons')
        ->name('coupons.reports.listing');
    Route::get('coupons/export/excel', 'ReportsController@excelExportCoupon')
        ->name('coupons.excel.report');
    Route::get('coupons/export/pdf', 'ReportsController@pdfExportCoupon')
        ->name('coupons.pdf.report');
    Route::get('/car_rentals', 'ReportsController@exportCarRentals')
        ->name('car_rentals.reports.listing');
    Route::get('car_rentals/export/excel', 'ReportsController@excelExportCarRental')
        ->name('car_rentals.excel.report');
    Route::get('car_rentals/export/pdf', 'ReportsController@pdfExportCarRental')
        ->name('car_rentals.pdf.report');
});

Route::group([
    'prefix' => 'pages',
], function () {
    Route::get('/privacy', 'PagesController@privacy')
        ->name('pages.page.privacy');
    Route::get('/terms', 'PagesController@terms')
        ->name('pages.page.terms');

    // Payment test
    Route::get('/payment', 'PagesController@paymentTest')
        ->name('pages.page.payment');

});

Route::get('/privacy_policy', 'PagesController@privacyPolicy')
    ->name('pages.page.privacy_policy')->middleware('can:view setting');
Route::get('/terms_conditions', 'PagesController@termsConditions')
    ->name('pages.page.terms_conditions')->middleware('can:view setting');


//Chats routes
Route::get('/chats', 'ChatsController@index')->name('chats.chat');
Route::get('/fetch_groups', 'ChatsController@fetchGroups');
Route::get('/fetch_group_users/{group}', 'ChatsController@fetchGroupUsers');
Route::get('/messages', 'ChatsController@fetchMessages');
Route::get('/group_messages/{group}', 'ChatsController@fetchGroupMessages');
Route::get('/user_messages/{user}', 'ChatsController@fetchUserMessages');
Route::post('/messages', 'ChatsController@sendMessage');


Route::group([
    'prefix' => 'groups',
], function () {
    Route::get('/', 'GroupsController@index')
         ->name('groups.group.index');
    Route::get('/create','GroupsController@create')
         ->name('groups.group.create');
    Route::get('/show/{group}','GroupsController@show')
         ->name('groups.group.show');
    Route::get('/{group}/edit','GroupsController@edit')
         ->name('groups.group.edit');
    Route::post('/', 'GroupsController@store')
         ->name('groups.group.store');
    Route::put('group/{group}', 'GroupsController@update')
         ->name('groups.group.update');
    Route::delete('/group/{group}','GroupsController@destroy')
         ->name('groups.group.destroy');
});




Route::get('/gps','GuestController@gps');
Route::get('/move/{token}/{trip_id}','GuestController@move');
Route::get('/d','GuestController@d');
Route::get('/d2','GuestController@d2');
// Route::get('/users','TripsController@getCurrentTrips');
Route::get('/preview/image', 'ChatController@preview_image')->name('preview.image');
Route::post('/old/messages', 'ChatController@old_messages')->name('old.messages');


// gps
// Route::get('/gps',[GuestController::class,'gps']);
// Route::get('/move',[GuestController::class,'move']);
// // Route::get('/d',[GuestController::class,'d']);
// // Route::get('/d2',[GuestController::class,'d2']);
// // Route::get('/users',[ChatController::class,'getCurrentTrips']);
// Route::get('/preview/image', [\App\Http\Controllers\Controller::class,'preview_image'])->name('preview.image');
// Route::post('/old/messages', [\App\Http\Controllers\Controller::class,'old_messages'])->name('old.messages');
