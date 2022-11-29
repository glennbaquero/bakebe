<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::namespace('Auth')->middleware('guest:admin')->group(function() {

    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login')->name('login');

    Route::get('reset-password/{token}/{email}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('reset-password/change', 'ResetPasswordController@reset')->name('password.change');

    Route::get('forgot-password', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('forgot-password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');

});

Route::middleware('auth:admin')->group(function() {

    Route::namespace('Auth')->group(function() {

        Route::get('logout', 'LoginController@logout')->name('logout');

    });

    Route::get('', 'DashboardController@index')->name('dashboard');

    /**
     * @Count Fetch Controller
     */
    Route::post('count/notifications', 'CountFetchController@fetchNotificationCount')->name('counts.fetch.notifications');
    Route::post('count/sample-items', 'CountFetchController@fetchSampleItemCount')->name('counts.fetch.sample-items.pending');
    
    /**
     * @Analytics
     */
    Route::namespace('Analytics')->group(function() {

        Route::post('analytics/dashboard', 'DashboardAnalyticsController@fetch')->name('analytics.fetch.user');
        Route::post('analytics/dashboard?admin=1', 'DashboardAnalyticsController@fetch')->name('analytics.fetch.admin');

        Route::post('analytics/sales', 'GraphController@fetchSales')->name('analytics.fetch.sales');

    });

    Route::namespace('Profiles')->group(function() {

        /**
         * @Admin Profiles
         */
        Route::get('profile', 'ProfileController@show')->name('profiles.show');
        Route::post('profile/update', 'ProfileController@update')->name('profiles.update');
        Route::post('profile/change-password', 'ProfileController@changePassword')->name('profiles.change-password');

        Route::post('profile/fetch', 'ProfileController@fetch')->name('profiles.fetch');

    });

    /**
     * @AdminUsers
     */
    Route::namespace('AdminUsers')->group(function() {

        /**
         * @AdminUsers
         */
        Route::get('admin-users', 'AdminUserController@index')->name('admin-users.index');
        Route::get('admin-users/create', 'AdminUserController@create')->name('admin-users.create');
        Route::post('admin-users/store', 'AdminUserController@store')->name('admin-users.store');
        Route::get('admin-users/show/{id}', 'AdminUserController@show')->name('admin-users.show');
        Route::post('admin-users/update/{id}', 'AdminUserController@update')->name('admin-users.update');
        Route::post('admin-users/{id}/archive', 'AdminUserController@archive')->name('admin-users.archive');
        Route::post('admin-users/{id}/restore', 'AdminUserController@restore')->name('admin-users.restore');

        Route::post('admin-users/fetch', 'AdminUserFetchController@fetch')->name('admin-users.fetch');
        Route::post('admin-users/fetch?archived=1', 'AdminUserFetchController@fetch')->name('admin-users.fetch-archive');
        Route::post('admin-users/fetch-item/{id?}', 'AdminUserFetchController@fetchView')->name('admin-users.fetch-item');
        Route::post('admin-users/fetch-pagination/{id}', 'AdminUserFetchController@fetchPagePagination')->name('admin-users.fetch-pagination');

    });

    /**
     * @Users
     */
    Route::namespace('Users')->group(function() {

        /**
         * @AdminUsers
         */
        Route::get('users', 'UserController@index')->name('users.index');
        Route::get('users/create', 'UserController@create')->name('users.create');
        Route::post('users/store', 'UserController@store')->name('users.store');
        Route::get('users/show/{id}', 'UserController@show')->name('users.show');
        Route::post('users/update/{id}', 'UserController@update')->name('users.update');
        Route::post('users/{id}/archive', 'UserController@archive')->name('users.archive');
        Route::post('users/{id}/restore', 'UserController@restore')->name('users.restore');
        Route::post('users/export', 'UserController@export')->name('users.export');

        Route::post('users/fetch', 'UserFetchController@fetch')->name('users.fetch');
        Route::post('users/fetch?archived=1', 'UserFetchController@fetch')->name('users.fetch-archive');
        Route::post('users/fetch-item/{id?}', 'UserFetchController@fetchView')->name('users.fetch-item');
        Route::post('users/fetch-pagination/{id}', 'UserFetchController@fetchPagePagination')->name('users.fetch-pagination');

    });

    /**
     * CMS Pages
     */
    Route::namespace('Pages')->group(function() {

        Route::get('pages', 'PageController@index')->name('pages.index');
        Route::get('pages/create', 'PageController@create')->name('pages.create');
        Route::post('pages/store', 'PageController@store')->name('pages.store');
        Route::get('pages/show/{id}', 'PageController@show')->name('pages.show');
        Route::post('pages/update/{id}', 'PageController@update')->name('pages.update');
        Route::post('pages/{id}/archive', 'PageController@archive')->name('pages.archive');
        Route::post('pages/{id}/restore', 'PageController@restore')->name('pages.restore');

        Route::post('pages/fetch', 'PageFetchController@fetch')->name('pages.fetch');
        Route::post('pages/fetch?archived=1', 'PageFetchController@fetch')->name('pages.fetch-archive');
        Route::post('pages/fetch-item/{id?}', 'PageFetchController@fetchView')->name('pages.fetch-item');
        Route::post('pages/fetch-pagination/{id}', 'PageFetchController@fetchPagePagination')->name('pages.fetch-pagination');

        Route::get('page-items', 'PageItemController@index')->name('page-items.index');
        Route::get('page-items/create', 'PageItemController@create')->name('page-items.create');
        Route::post('page-items/store', 'PageItemController@store')->name('page-items.store');
        Route::get('page-items/show/{id}', 'PageItemController@show')->name('page-items.show');
        Route::post('page-items/update/{id}', 'PageItemController@update')->name('page-items.update');
        Route::post('page-items/{id}/archive', 'PageItemController@archive')->name('page-items.archive');
        Route::post('page-items/{id}/restore', 'PageItemController@restore')->name('page-items.restore');

        Route::post('page-items/fetch', 'PageItemFetchController@fetch')->name('page-items.fetch');
        Route::post('page-items/fetch?archived=1', 'PageItemFetchController@fetch')->name('page-items.fetch-archive');
        Route::post('page-items/fetch?page_id={id}', 'PageItemFetchController@fetch')->name('page-items.fetch-page-items');
        Route::post('page-items/fetch-item/{id?}', 'PageItemFetchController@fetchView')->name('page-items.fetch-item');
        Route::post('page-items/fetch-pagination/{id}', 'PageItemFetchController@fetchPagePagination')->name('page-items.fetch-pagination');

    });

    /**
     * @Roles
     */
    Route::namespace('Roles')->group(function() {

        Route::get('roles', 'RoleController@index')->name('roles.index');
        Route::get('roles/create', 'RoleController@create')->name('roles.create');
        Route::post('roles/store', 'RoleController@store')->name('roles.store');
        Route::get('roles/{id}', 'RoleController@show')->name('roles.show');
        Route::post('roles/{id}/update', 'RoleController@update')->name('roles.update');
        Route::post('roles/{id}/archive', 'RoleController@archive')->name('roles.archive');
        Route::post('roles/{id}/restore', 'RoleController@restore')->name('roles.restore');

        Route::post('roles/{id}/update-permission', 'RoleController@updatePermissions')->name('roles.update-permissions');

        Route::post('roles/fetch', 'RoleFetchController@fetch')->name('roles.fetch');
        Route::post('roles/fetch?archived=1', 'RoleFetchController@fetch')->name('roles.fetch-archive');
        Route::post('roles/fetch-item/{id?}', 'RoleFetchController@fetchView')->name('roles.fetch-item');
        Route::post('role/fetch-pagination/{id}', 'RoleFetchController@fetchPagePagination')->name('roles.fetch-pagination');

    });

    /**
     * @Permissions
     */
    Route::namespace('Permissions')->group(function() {

        Route::post('permissions-fetch/{id?}', 'PermissionFetchController@fetch')->name('permissions.fetch');

    });

    Route::namespace('Notifications')->group(function() {

        Route::get('notifications', 'NotificationController@index')->name('notifications.index');
        Route::post('notifications/all/mark-as-read', 'NotificationController@readAll')->name('notifications.read-all');
        Route::post('notifications/{id}/read', 'NotificationController@read')->name('notifications.read');
        Route::post('notifications/{id}/unread', 'NotificationController@unread')->name('notifications.unread');
        
        Route::post('notifications-fetch', 'NotificationFetchController@fetch')->name('notifications.fetch');
        Route::post('notifications-fetch?read=1', 'NotificationFetchController@fetch')->name('notifications.fetch-read');
        Route::post('notifications-fetch?unread=1', 'NotificationFetchController@fetch')->name('notifications.fetch-unread');

    });

    Route::namespace('ActivityLogs')->group(function() {

        Route::get('activity-logs', 'ActivityLogController@index')->name('activity-logs.index');
        Route::post('activity-logs/fetch', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch');

        Route::post('activity-logs/fetch?id={id?}&sample=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.sample-items');

        Route::post('activity-logs/fetch?id={id?}&admin=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.admin-users');
        Route::post('activity-logs/fetch?id={id?}&user=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.users');

        Route::post('activity-logs/fetch?profile=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.profiles');

        Route::post('activity-logs/fetch?id={id?}&roles=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.roles');

        Route::post('activity-logs/fetch?id={id?}&pagecontents=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.pages');

        Route::post('activity-logs/fetch?id={id?}&pageitems=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.page-items');

        Route::post('activity-logs/fetch?id={id?}&articles=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.articles');

        Route::post('activity-logs/fetch?id={id?}&branches=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.branches');

        Route::post('activity-logs/fetch?id={id?}&coupons=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.coupons');

        Route::post('activity-logs/fetch?id={id?}&promos=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.promos');

        Route::post('activity-logs/fetch?id={id?}&categories=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.categories');     

        Route::post('activity-logs/fetch?id={id?}&pastries=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.pastries');        

        Route::post('activity-logs/fetch?id={id?}&intervals=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.intervals');    

        Route::post('activity-logs/fetch?id={id?}&types=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.types');        

        Route::post('activity-logs/fetch?id={id?}&hows=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.hows');        

    });

    Route::namespace('Articles')->group(function() {
        Route::get('articles', 'ArticleController@index')->name('articles.index');
        Route::get('articles/create', 'ArticleController@create')->name('articles.create');
        Route::post('articles/store', 'ArticleController@store')->name('articles.store');
        Route::get('articles/show/{id}', 'ArticleController@show')->name('articles.show');
        Route::post('articles/update/{id}', 'ArticleController@update')->name('articles.update');
        Route::post('articles/{id}/archive', 'ArticleController@archive')->name('articles.archive');
        Route::post('articles/{id}/restore', 'ArticleController@restore')->name('articles.restore');
        Route::post('articles/{id}/remove-image', 'ArticleController@removeImage')->name('articles.remove-image');

        Route::post('articles/fetch', 'ArticleFetchController@fetch')->name('articles.fetch');
        Route::post('articles/fetch?archived=1', 'ArticleFetchController@fetch')->name('articles.fetch-archive');
        Route::post('articles/fetch-item/{id?}', 'ArticleFetchController@fetchView')->name('articles.fetch-item');
        Route::post('articles/fetch-pagination/{id}', 'ArticleFetchController@fetchPagePagination')->name('articles.fetch-pagination');
    });

    Route::namespace('Samples')->group(function() {
        Route::get('sample-items', 'SampleItemController@index')->name('sample-items.index');
        Route::get('sample-items/create', 'SampleItemController@create')->name('sample-items.create');
        Route::post('sample-items/store', 'SampleItemController@store')->name('sample-items.store');
        Route::get('sample-items/show/{id}', 'SampleItemController@show')->name('sample-items.show');
        Route::post('sample-items/update/{id}', 'SampleItemController@update')->name('sample-items.update');
        Route::post('sample-items/{id}/archive', 'SampleItemController@archive')->name('sample-items.archive');
        Route::post('sample-items/{id}/restore', 'SampleItemController@restore')->name('sample-items.restore');
        Route::post('sample-items/{id}/remove-image', 'SampleItemController@removeImage')->name('sample-items.remove-image');

        Route::post('sample-items/export', 'SampleItemController@export')->name('sample-items.export');

        Route::post('sample-items/{id}/approve', 'SampleItemController@approve')->name('sample-items.approve');
        Route::post('sample-items/{id}/deny', 'SampleItemController@deny')->name('sample-items.deny');

        Route::post('sample-items/fetch', 'SampleItemFetchController@fetch')->name('sample-items.fetch');
        Route::post('sample-items/fetch?archived=1', 'SampleItemFetchController@fetch')->name('sample-items.fetch-archive');
        Route::post('sample-items/fetch-item/{id?}', 'SampleItemFetchController@fetchView')->name('sample-items.fetch-item');
        Route::post('sample-items/fetch-pagination/{id}', 'SampleItemFetchController@fetchPagePagination')->name('sample-items.fetch-pagination');
    });

    /**
     * @Branches
     */    
    Route::namespace('Branches')->group(function() {
        Route::get('branches', 'BranchController@index')->name('branches.index');
        Route::get('branches/create', 'BranchController@create')->name('branches.create');
        Route::post('branches/store', 'BranchController@store')->name('branches.store');
        Route::get('branches/show/{id}', 'BranchController@show')->name('branches.show');
        Route::post('branches/update/{id}', 'BranchController@update')->name('branches.update');
        Route::post('branches/{id}/archive', 'BranchController@archive')->name('branches.archive');
        Route::post('branches/{id}/restore', 'BranchController@restore')->name('branches.restore');
        Route::post('branches/fetch/positions', 'BranchController@fetchPositions')->name('branches.fetch-position');
    
        Route::post('branches/fetch', 'BranchFetchController@fetch')->name('branches.fetch');
        Route::post('branches/fetch?archived=1', 'BranchFetchController@fetch')->name('branches.fetch-archive');
        Route::post('branches/fetch-item/{id?}', 'BranchFetchController@fetchView')->name('branches.fetch-item');
        Route::post('branches/fetch-pagination/{id}', 'BranchFetchController@fetchPagePagination')->name('branches.fetch-pagination');
    });    

    /**
     * @Coupons
     */    
    Route::namespace('Coupons')->group(function() {
        Route::get('coupons', 'CouponController@index')->name('coupons.index');
        Route::get('coupons/create', 'CouponController@create')->name('coupons.create');
        Route::post('coupons/store', 'CouponController@store')->name('coupons.store');
        Route::get('coupons/show/{id}', 'CouponController@show')->name('coupons.show');
        Route::post('coupons/update/{id}', 'CouponController@update')->name('coupons.update');
        Route::post('coupons/{id}/archive', 'CouponController@archive')->name('coupons.archive');
        Route::post('coupons/{id}/restore', 'CouponController@restore')->name('coupons.restore');
    
        Route::post('coupons/fetch', 'CouponFetchController@fetch')->name('coupons.fetch');
        Route::post('coupons/fetch?archived=1', 'CouponFetchController@fetch')->name('coupons.fetch-archive');
        Route::post('coupons/fetch-item/{id?}', 'CouponFetchController@fetchView')->name('coupons.fetch-item');
        Route::post('coupons/fetch-pagination/{id}', 'CouponFetchController@fetchPagePagination')->name('coupons.fetch-pagination');
    });

    /**
     * @Promos
     */    
    Route::namespace('Promos')->group(function() {
        Route::get('promos', 'PromoController@index')->name('promos.index');
        Route::get('promos/create', 'PromoController@create')->name('promos.create');
        Route::post('promos/store', 'PromoController@store')->name('promos.store');
        Route::get('promos/show/{id}', 'PromoController@show')->name('promos.show');
        Route::post('promos/update/{id}', 'PromoController@update')->name('promos.update');
        Route::post('promos/{id}/archive', 'PromoController@archive')->name('promos.archive');
        Route::post('promos/{id}/restore', 'PromoController@restore')->name('promos.restore');
    
        Route::post('promos/fetch', 'PromoFetchController@fetch')->name('promos.fetch');
        Route::post('promos/fetch?archived=1', 'PromoFetchController@fetch')->name('promos.fetch-archive');
        Route::post('promos/fetch-item/{id?}', 'PromoFetchController@fetchView')->name('promos.fetch-item');
        Route::post('promos/fetch-pagination/{id}', 'PromoFetchController@fetchPagePagination')->name('promos.fetch-pagination');
    });

    /**
     * @Pastries Category
     */    
    Route::namespace('Pastries')->group(function() {
        Route::get('categories', 'CategoryController@index')->name('categories.index');
        Route::get('categories/create', 'CategoryController@create')->name('categories.create');
        Route::post('categories/store', 'CategoryController@store')->name('categories.store');
        Route::get('categories/show/{id}', 'CategoryController@show')->name('categories.show');
        Route::post('categories/update/{id}', 'CategoryController@update')->name('categories.update');
        Route::post('categories/{id}/archive', 'CategoryController@archive')->name('categories.archive');
        Route::post('categories/{id}/restore', 'CategoryController@restore')->name('categories.restore');
    
        Route::post('categories/fetch', 'CategoryFetchController@fetch')->name('categories.fetch');
        Route::post('categories/fetch?archived=1', 'CategoryFetchController@fetch')->name('categories.fetch-archive');
        Route::post('categories/fetch-item/{id?}', 'CategoryFetchController@fetchView')->name('categories.fetch-item');
        Route::post('categories/fetch-pagination/{id}', 'CategoryFetchController@fetchPagePagination')->name('categories.fetch-pagination');
    });

    /**
     * @Pastries
     */    
    Route::namespace('Pastries')->group(function() {
        Route::get('pastries', 'PastryController@index')->name('pastries.index');
        Route::get('pastries/create', 'PastryController@create')->name('pastries.create');
        Route::post('pastries/store', 'PastryController@store')->name('pastries.store');
        Route::get('pastries/show/{id}', 'PastryController@show')->name('pastries.show');
        Route::post('pastries/update/{id}', 'PastryController@update')->name('pastries.update');
        Route::post('pastries/{id}/archive', 'PastryController@archive')->name('pastries.archive');
        Route::post('pastries/{id}/restore', 'PastryController@restore')->name('pastries.restore');
    
        Route::post('pastries/fetch', 'PastryFetchController@fetch')->name('pastries.fetch');
        Route::post('pastries/fetch?archived=1', 'PastryFetchController@fetch')->name('pastries.fetch-archive');
        Route::post('pastries/fetch-item/{id?}', 'PastryFetchController@fetchView')->name('pastries.fetch-item');
        Route::post('pastries/fetch-pagination/{id}', 'PastryFetchController@fetchPagePagination')->name('pastries.fetch-pagination');
    });

    /**
     * @Intervals
     */    
    Route::namespace('Intervals')->group(function() {
        Route::get('blocking', 'BlockDateIntervalController@index')->name('intervals.index');
        Route::get('blocking/create', 'BlockDateIntervalController@create')->name('intervals.create');
        Route::post('blocking/store', 'BlockDateIntervalController@store')->name('intervals.store');
        Route::get('blocking/show/{id}', 'BlockDateIntervalController@show')->name('intervals.show');
        Route::post('blocking/update/{id}', 'BlockDateIntervalController@update')->name('intervals.update');
        Route::post('blocking/{id}/archive', 'BlockDateIntervalController@archive')->name('intervals.archive');
        Route::post('blocking/{id}/restore', 'BlockDateIntervalController@restore')->name('intervals.restore');
    
        Route::post('blocking/fetch', 'BlockDateIntervalFetchController@fetch')->name('intervals.fetch');
        Route::post('blocking/fetch?archived=1', 'BlockDateIntervalFetchController@fetch')->name('intervals.fetch-archive');
        Route::post('blocking/fetch-item/{id?}', 'BlockDateIntervalFetchController@fetchView')->name('intervals.fetch-item');
        Route::post('blocking/fetch-pagination/{id}', 'BlockDateIntervalFetchController@fetchPagePagination')->name('intervals.fetch-pagination');
    });

    /**
     * @Reservations
     */    
    Route::namespace('Reservations')->group(function() {
        Route::get('reservations', 'InvoiceController@index')->name('bookings.index');
        // Route::get('reservations/create', 'InvoiceController@create')->name('bookings.create');
        // Route::post('reservations/store', 'InvoiceController@store')->name('bookings.store');
        Route::get('reservations/show/{id}', 'InvoiceController@show')->name('bookings.show');
        Route::post('reservations/update/{id}', 'InvoiceController@update')->name('bookings.update');
        Route::post('reservations/export/report', 'InvoiceController@export')->name('bookings.export-report');
        Route::post('invoice/mark-claimed/{id}', 'InvoiceController@invoiceMarkAsClaimed')->name('invoice.mark-claimed');

        Route::post('item/claimed/{id}', 'InvoiceController@markAsClaimed')->name('invoice-items.mark-as-claimed');
    
        Route::post('reservations/fetch', 'InvoiceFetchController@fetch')->name('bookings.fetch');
        Route::post('reservations/fetch?archived=1', 'InvoiceFetchController@fetch')->name('bookings.fetch-archive');
        Route::post('reservations/fetch-item/{id?}', 'InvoiceFetchController@fetchView')->name('bookings.fetch-item');
        Route::post('reservations/fetch-pagination/{id}', 'InvoiceFetchController@fetchPagePagination')->name('bookings.fetch-pagination');
    });
    /**
     * @Coupon Usages
     */    
    Route::namespace('CouponUsages')->group(function() {
            Route::get('couponusages', 'CouponUsageController@index')->name('couponusages.index');
            Route::get('couponusages/show/{id}', 'CouponUsageController@show')->name('couponusages.show');
            Route::get('couponusages/show/{id}', 'CouponUsageController@showInvoice')->name('reservations.show');
            Route::post('couponusages/update/{id}', 'CouponUsageController@update')->name('couponusages.update');

            Route::post('couponusages/fetch', 'CouponUsageFetchController@fetch')->name('couponusages.fetch');
            Route::post('couponusages/fetch?archived=1', 'CouponUsageFetchController@fetch')->name('couponusages.fetch-archive');
            Route::post('couponusages/fetch-item/{id?}', 'CouponUsageFetchController@fetchView')->name('couponusages.fetch-item');
            Route::post('couponusages/fetch-pagination/{id}', 'CouponUsageFetchController@fetchPagePagination')->name('couponusages.fetch-pagination');
    });    

    /**
     * @Booking Types
     */    
    Route::namespace('Types')->group(function() {
            Route::get('types', 'BookingTypeController@index')->name('types.index');
            Route::get('types/show/{id}', 'BookingTypeController@show')->name('types.show');
            Route::post('types/update/{id}', 'BookingTypeController@update')->name('types.update');

            
            Route::post('types/{id}/archive', 'BookingTypeController@archive')->name('types.archive');
            Route::post('types/{id}/restore', 'BookingTypeController@restore')->name('types.restore');
            
            Route::post('types/fetch', 'BookingTypeFetchController@fetch')->name('types.fetch');
            Route::post('types/fetch?archived=1', 'BookingTypeFetchController@fetch')->name('types.fetch-archive');
            Route::post('types/fetch-item/{id?}', 'BookingTypeFetchController@fetchView')->name('types.fetch-item');
            Route::post('types/fetch-pagination/{id}', 'BookingTypeFetchController@fetchPagePagination')->name('types.fetch-pagination');
    });    

    /**
     * @HowToReserve
     */    
    Route::namespace('Hows')->group(function() {
            Route::get('hows', 'HowController@index')->name('hows.index');
            Route::get('hows/create', 'HowController@create')->name('hows.create');
            Route::post('hows/store', 'HowController@store')->name('hows.store');
            Route::get('hows/show/{id}', 'HowController@show')->name('hows.show');
            Route::post('hows/update/{id}', 'HowController@update')->name('hows.update');
            Route::post('hows/{id}/archive', 'HowController@archive')->name('hows.archive');
            Route::post('hows/{id}/restore', 'HowController@restore')->name('hows.restore');            

            Route::post('hows/fetch', 'HowFetchController@fetch')->name('hows.fetch');
            Route::post('hows/fetch?archived=1', 'HowFetchController@fetch')->name('hows.fetch-archive');
            Route::post('hows/fetch-item/{id?}', 'HowFetchController@fetchView')->name('hows.fetch-item');
            Route::post('hows/fetch-pagination/{id}', 'HowFetchController@fetchPagePagination')->name('hows.fetch-pagination');
    });

});