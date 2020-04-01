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

// admin routes
Route::group(['middleware' => 'employee'], function () {

	Route::group(['prefix'=>'my-bookings', 'as' => 'myBookings.'], function() {
		Route::redirect('/', 'my-bookings/all');
		Route::get('/all', 'Employee\BookingController@index')->name('all');
		Route::get('/pending', 'Employee\BookingController@pendingPage')->name('pending');
		Route::get('/processing', 'Employee\BookingController@processingPage')->name('processing');
	});

	
	Route::get('request-booking', 'Employee\BookingController@create')->name('requestBooking');
	Route::post('submitBooking', 'Employee\BookingController@store')->name('submitBooking');
});


// admin routes
Route::group(['middleware' => 'admin'], function () {

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
