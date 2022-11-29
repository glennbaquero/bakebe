<?php

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
|
| Here is where you can register guest routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "guest" middleware group. Now create something great!
|
*/


/* Page Routes */
Route::namespace('Pages')->group(function() {

	Route::get('', 'PageController@showHome')->name('home');
	Route::get('terms-and-conditions', 'PageController@showTerms')->name('terms');
	Route::get('privacy-policy', 'PageController@showPrivacy')->name('privacy');

	Route::get('booking', 'PageController@showBooking')->name('booking');
	Route::post('get/block/dates-time', 'PageController@branchBlockDate')->name('branch.block-dates-intervals');

	Route::get('forgot-password', function () {
    		return view('guest/pages/forgot-password');
	});
});

Route::namespace('Pastries')->group(function() {
	Route::post('pastries/fetch', 'PastryFetchController@fetch')->name('pastries.fetch');
});

Route::namespace('Invoices')->group(function() {
	Route::post('blocked-dates/fetch', 'InvoiceFetchController@fetch')->name('blocks.fetch');
});

Route::namespace('Timeslots')->group(function() {
	Route::post('timeslot', 'TimeslotController@getTimeSlot')->name('timeslot');
	Route::post('fullybooked/dates', 'TimeslotController@getFullyBookedDates')->name('fullybooked');
});

Route::namespace('Coupons')->group(function() {
	Route::post('coupon/checker', 'CouponController@verify')->name('voucher-checker');

	Route::middleware('auth:web')->group(function() {
		Route::post('get/discount', 'CouponController@couponDiscount')->name('coupon-discount');
	});
});