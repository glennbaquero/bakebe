<?php

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

// \Auth::routes();


Route::namespace('PaymentGateways')->group(function() {
    Route::middleware('guest:web')->group(function() {
        Route::get('payment/paymaya/success', 'PaymayaController@success')->name('paymaya.success');
        Route::get('payment/paymaya/failure', 'PaymayaController@failure')->name('paymaya.failure');
        Route::get('payment/paymaya/cancel', 'PaymayaController@cancel')->name('paymaya.cancel');

        Route::post('payment/paymaya/callback-success', 'PaymayaController@callback')->name('paymaya.callback-success');
        Route::post('payment/paymaya/callback-failure', 'PaymayaController@callback')->name('paymaya.callback-failure');
        Route::post('payment/paymaya/callback-dropout', 'PaymayaController@callback')->name('paymaya.callback-dropout');


        Route::post('checkout/processPaynamics', 'PaynamicsController@processPaynamics')->name('paynamics.process_paynamics');
        Route::get('checkout/paynamicsReturn', 'PaynamicsController@paynamicsReturn')->name('paynamics.paynamics_return');        
        Route::get('checkout/paynamicsCancel', 'PaynamicsController@paynamicsCancel')->name('paynamics.paynamics-cancel');

    });
});

Route::namespace('Auth')->group(function() {

    Route::get('email/verify/{id}', 'VerificationController@verify')->name('verification.verify');
    
    Route::middleware('auth:web')->group(function() {
        Route::get('logout', 'LoginController@logout')->name('logout');

        Route::get('dashboard/show/', function () {
             return view('web/pages/booking-history');
        });

        Route::get('/edit-profile', function () {
             return view('web/pages/edit-profile');
        });

        Route::get('/change-password', function () {
             return view('web/pages/change-password');
        });

        
    });

    Route::get('/invoice', function () {
         return view('web/pages/invoice');
    });


	/* Guest Routes */
	Route::middleware('guest:web')->group(function() {

        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login')->name('login');

        Route::get('reset-password/{token}/{email}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('reset-password/change', 'ResetPasswordController@reset')->name('password.change');

        Route::get('forgot-password', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('forgot-password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');

        Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'RegisterController@register');

        /* Socialite Login */
        Route::get('socialite/{provider}/login', 'SocialiteLoginController@login')->name('socialite.login');
		Route::get('socialite/{provider}/callback', 'SocialiteLoginController@callback')->name('socialite.callback');

		/* Facebook Login */
		Route::get('socialite/facebook/login', 'SocialiteLoginController@login')->name('facebook.login');
		Route::get('socialite/facebook/callback', 'SocialiteLoginController@callback')->name('facebook.callback');

        Route::get('', 'PageController@showHome')->name('home');
        Route::get('terms-and-conditions', 'PageController@showTerms')->name('terms');
        Route::get('privacy-policy', 'PageController@showPrivacy')->name('privacy');


	});
});

Route::middleware('auth:web')->group(function() {
     Route::namespace('Carts')->group(function() {
            Route::post('/upload/cart-items', 'CartController@guestCartToUserCart')->name('cart.guest-user');
            Route::post('/insert/item', 'CartController@createCartItem')->name('cart.insert-item');
            Route::post('/update/cart', 'CartController@cartUpdate')->name('cart.update');
            Route::post('/truncate/cart-item', 'CartController@truncateCartItem')->name('cart-item.truncate');
            Route::post('/fetch/cart-item', 'CartFetchController@fetch')->name('cart.fetch');
            Route::post('/remove/cart-items/{id}', 'CartController@deleteCartItem')->name('cart.remove-item');
            Route::post('/update/cart-items/{id}', 'CartController@updateCartItem')->name('cart.update-item');
        });

     Route::namespace('PaymentGateways')->group(function() {
        Route::post('payment/paymaya', 'PaymayaController@checkout')->name('paymaya.checkout');
        Route::post('/generate/form', 'PaynamicsController@generatePaynamicsForm')->name('paynamics.generate-form');
        Route::post('payment/paypal', 'PaypalController@checkout')->name('paypal.checkout');
     });
 });

/* User Dashboard Routes */
Route::prefix('dashboard')->middleware('auth:web')->group(function() {
    Route::match(['get', 'post'],'', 'DashboardController@index')->name('dashboard');


	Route::namespace('Auth')->group(function() {

		Route::get('logout', 'LoginController@logout')->name('logout');

        // Route::get('email/reset', 'VerificationController@resend')->name('verification.resend');
        // Route::get('email/verify', 'VerificationController@show')->name('verification.notice');

	});

	Route::middleware('verified')->group(function() {

		// Route::match(['get', 'post'],'', 'DashboardController@index')->name('dashboard');
    Route::match(['get', 'post'],'', 'DashboardController@index')->name('dashboard');

		/**
         * @Count Fetch Controller
         */
        Route::post('count/notifications', 'CountFetchController@fetchNotificationCount')->name('counts.fetch.notifications');

		Route::namespace('Profiles')->group(function() {

            /**
             * @Profiles
             */
            Route::get('profile', 'ProfileController@show')->name('profiles.show');
            Route::post('profile/update', 'ProfileController@update')->name('profiles.update');

            Route::get('profile/change-password', 'ProfileController@showPassword')->name('profiles.change-password');
            Route::post('profile/change-password', 'ProfileController@changePassword')->name('profiles.change-password');

            Route::post('profile/fetch', 'ProfileController@fetch')->name('profiles.fetch');

        });

		Route::namespace('ActivityLogs')->group(function() {

            Route::get('activity-logs', 'ActivityLogController@index')->name('activity-logs.index');
            
            Route::post('activity-logs/fetch', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch');
            Route::post('activity-logs/fetch?id={id?}&sample=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.sample-items');
            Route::post('activity-logs/fetch?profile=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.profiles');

        });

        Route::namespace('Users')->group(function() {
            Route::middleware('auth:web')->group(function() {
                Route::post('/user/show/', 'UserController@fetchView')->name('user.fetch-profile');
                Route::post('/user/update/profile', 'UserController@updateProfile')->name('user.update-profile');                
                Route::post('/user/update/password', 'UserController@updatePassword')->name('user.update-password');
            });
        
        });
        
        Route::namespace('Bookings')->group(function() {
            Route::middleware('auth:web')->group(function() {
               Route::post('/fetch/history', 'BookingFetchController@fetch')->name('history.fetch');
               Route::get('/show/{id}', 'BookingController@showInvoice')->name('history.show');
               Route::get('/print/{id}', 'BookingController@printInvoice')->name('history.print');
            });
        });    
        /* Page Routes */
        Route::namespace('Pages')->group(function() {

            Route::get('/user-signup', function () {
                    return view('guest/pages/signup');
            });

        });

    });
});
