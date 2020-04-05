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

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('dashboard');
});

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('dashboard');
Route::get('/profile/{user_name}', 'HomeController@profile')->name('profile');
Route::post('/updateProfile', 'HomeController@updateProfile')->name('updateProfile');

// employee routes
Route::group(['middleware' => 'employee'], function () {

	Route::group(['prefix'=>'my-booking', 'as' => 'myBooking.'], function() {
		Route::redirect('/', 'booking/all');
		Route::get('/all', 'Employee\BookingController@index')->name('all')->middleware(['stripEmptyParams']);
		Route::get('/pending', 'Employee\BookingController@pendingPage')->name('pending')->middleware(['stripEmptyParams']);
		Route::get('/processed', 'Employee\BookingController@processedPage')->name('processed')->middleware(['stripEmptyParams']);
		Route::get('/approved', 'Employee\BookingController@approvedPage')->name('approved')->middleware(['stripEmptyParams']);
		Route::get('/completed', 'Employee\BookingController@completedPage')->name('completed')->middleware(['stripEmptyParams']);
		Route::get('/cancelled', 'Employee\BookingController@cancelledPage')->name('cancelled')->middleware(['stripEmptyParams']);

		Route::get('/view/{bookingNumber}', 'Employee\BookingController@show')->name('view');
	});

	Route::get('request-booking', 'Employee\BookingController@create')->name('requestBooking');
	Route::post('submitBooking', 'Employee\BookingController@store')->name('submitBooking');
	Route::post('cancelBooking', 'Employee\BookingController@cancel')->name('cancelBooking');

	Route::get('/my-schedule', 'Employee\EmployeeController@mySchedulePage')->name('mySchedulePage');
	Route::get('/myScheduleList', 'Employee\EmployeeController@myScheduleList')->name('myScheduleList')->middleware(['stripEmptyParams']);
});

// admin routes
Route::group(['middleware' => 'driver', 'as' => 'driver.'], function () {
	Route::get('/driverScheduleList', 'Driver\DriverController@driverScheduleList')->name('driverScheduleList')->middleware(['stripEmptyParams']);
	Route::patch('updateVehicleStats/{id}', 'Driver\DriverController@updateVehicleStats')->name('updateVehicleStats');
	Route::patch('updateVehicleStats/{id}', 'Driver\DriverController@updateVehicleStats')->name('updateVehicleStats');

	Route::group(['prefix'=>'assigned-booking', 'as' => 'assignedBooking.'], function() {
		Route::redirect('/', 'assigned-booking/all');
		Route::get('/all', 'Driver\BookingController@index')->name('all')->middleware(['stripEmptyParams']);
		Route::get('/approved', 'Driver\BookingController@approvedPage')->name('approved')->middleware(['stripEmptyParams']);
		Route::get('/completed', 'Driver\BookingController@completedPage')->name('completed')->middleware(['stripEmptyParams']);
		Route::get('/cancelled', 'Driver\BookingController@cancelledPage')->name('cancelled')->middleware(['stripEmptyParams']);
		Route::get('/view/{bookingNumber}', 'Driver\BookingController@show')->name('view');
	});

});

// admin routes
Route::group(['middleware' => 'admin', 'as' => 'admin.'], function () {

	Route::get('/scheduleList', 'Admin\AdminController@scheduleList')->name('scheduleList')->middleware(['stripEmptyParams']);

	Route::get('/process-booking', 'Admin\BookingController@processBookingPage')->name('processBookingPage')->middleware(['stripEmptyParams'])->middleware(['stripEmptyParams', 'dispatcher']);
	Route::get('/process-booking/{bookingNumber}', 'Admin\BookingController@processBookingShow')->name('processedBookingShow')->middleware(['dispatcher']);
	Route::patch('processBooking/{id}', 'Admin\BookingController@processBooking')->name('processBooking');
	
	Route::get('/approve-booking', 'Admin\BookingController@approveBookingPage')->name('approveBookingPage')->middleware(['stripEmptyParams', 'director']);
	Route::get('/approve-booking/{bookingNumber}', 'Admin\BookingController@approveBookingShow')->name('approveBookingShow')->middleware(['director']);
	Route::patch('approveBooking/{id}', 'Admin\BookingController@approveBooking')->name('approveBooking');

	Route::patch('completeBooking/{id}', 'Admin\BookingController@completeBooking')->name('completeBooking');
	Route::post('adminCancelBooking', 'Admin\BookingController@cancel')->name('cancelBooking');

	Route::group(['prefix'=>'booking', 'as' => 'booking.'], function() {
		Route::redirect('/', 'booking/all');
		Route::get('/all', 'Admin\BookingController@index')->name('all')->middleware(['stripEmptyParams']);
		Route::get('/pending', 'Admin\BookingController@pendingPage')->name('pending')->middleware(['stripEmptyParams']);
		Route::get('/processed', 'Admin\BookingController@processedPage')->name('processed')->middleware(['stripEmptyParams']);
		Route::get('/approved', 'Admin\BookingController@approvedPage')->name('approved')->middleware(['stripEmptyParams']);
		Route::get('/completed', 'Admin\BookingController@completedPage')->name('completed')->middleware(['stripEmptyParams']);
		Route::get('/cancelled', 'Admin\BookingController@cancelledPage')->name('cancelled')->middleware(['stripEmptyParams']);

		Route::get('/view/{bookingNumber}', 'Admin\BookingController@show')->name('view');
	});


	// user routes
	Route::group(['prefix'=>'user', 'as' => 'user.'], function() {
	    Route::redirect('/', 'user/list');
	    Route::get('list', 'Admin\UserController@index')->name('list')->middleware(['stripEmptyParams']);

		Route::group(['middleware' => 'dispatcher'], function () {
		    Route::get('create', 'Admin\UserController@create')->name('create');
		    Route::get('edit/{id}', 'Admin\UserController@edit')->name('edit');
		    Route::post('submit', 'Admin\UserController@store')->name('store');
		    Route::patch('update/{id}', 'Admin\UserController@update')->name('update');
		    Route::delete('delete/{id}', 'Admin\UserController@destroy')->name('delete');
		});

	});

	// vehicle route
	Route::group(['prefix'=>'vehicle', 'as' => 'vehicle.'], function() {
		Route::redirect('/', 'vehicle/list');
		Route::get('list', 'Admin\VehicleController@index')->name('list')->middleware(['stripEmptyParams']);	

		Route::group(['middleware' => 'dispatcher'], function () {
			Route::get('create', 'Admin\VehicleController@create')->name('create');
		    Route::get('edit/{id}', 'Admin\VehicleController@edit')->name('edit');
		    Route::post('submit', 'Admin\VehicleController@store')->name('store');
		    Route::patch('update/{id}', 'Admin\VehicleController@update')->name('update');
		    Route::patch('updateStats/{id}', 'Admin\VehicleController@updateStats')->name('updateStats');
		    Route::delete('delete/{id}', 'Admin\VehicleController@destroy')->name('delete');
		});

    });

});
