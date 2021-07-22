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

Route::group(['prefix' => 'reports'], function () {
    Route::get('/users/role', [
        'as' => 'api-reports-users-role',
        'uses' => 'Api\ReportNewUsersByRoleController'
    ]);

    Route::get('/users/login', [
        'as' => 'api-reports-users-login',
        'uses' => 'Api\ReportLoginUsersController'
    ]);

    Route::get('/users/tickets', [
        'as' => 'api-reports-tickets',
        'uses' => 'Api\ReportTicketsController'
    ]);
});

Route::post('/confirm-payment', [
    'as' => 'api-confirm-payment',
    'uses' => 'Api\PaymentConfirmController'
]);

Route::group(['prefix' => 'users'], function () {
    Route::post('/init', [
        'as' => 'api-users-login',
        'uses' => 'Api\LoginController'
    ]);

    Route::post('/generate-otp', [
        'as' => 'api-generate-otp',
        'uses' => 'Api\GenerateOTPController'
    ]);

    Route::post('/verify-otp', [
        'as' => 'api-verify-otp',
        'uses' => 'Api\VerifyOTPController'
    ]);

    Route::post('/register/client', [
        'as' => 'api-users-register-client',
        'uses' => 'Api\RegisterClientController'
    ]);

    Route::get('/location', [
        'as' => 'api-users-location',
        'uses' => 'Api\LocationController'
    ]);

    Route::post('/location/create', [
        'as' => 'api-users-location-create',
        'uses' => 'Api\CreateLocationController'
    ]);

    Route::post('/ticket/create', [
        'as' => 'api-ticket-create',
        'uses' => 'Api\CreateTicketController'
    ]);

    Route::post('/ticket/reply', [
        'as' => 'api-users-ticket-reply',
        'uses' => 'Api\ReplyTicketController'
    ]);

    Route::get('/ticket/{ticket}/messages', [
        'as' => 'api-users-ticket-messages',
        'uses' => 'Api\GetMessagesFromTicketController'
    ]);

    Route::get('/ticket', [
        'as' => 'api-users-ticket',
        'uses' => 'Api\GetTicketByUserController'
    ]);

    Route::get('/profile', [
        'as' => 'api-users-profile',
        'uses' => 'Api\ProfileUserController'
    ]);

    Route::post('/profile/edit', [
        'as' => 'api-users-edit-profile',
        'uses' => 'Api\EditUserProfileController'
    ]);

    Route::get('/orders', [
        'as' => 'api-users-orders',
        'uses' => 'Api\GetOrdersByUserController'
    ]);

    Route::get('/orders/{order}/products', [
        'as' => 'api-users-orders-products',
        'uses' => 'Api\GerProductsByOrderController'
    ]);

    Route::get('/seller/{seller}/info', [
        'as' => 'api-users-seller',
        'uses' => 'Api\SellerInfoController'
    ]);

    Route::post('/rating', [
        'as' => 'api-rating',
        'uses' => 'Api\RatingOrderController'
    ]);
});

Route::group(['prefix' => 'commerces'], function () {
    Route::get('/profile', [
        'as' => 'api-commerces-profile',
        'uses' => 'Api\ProfileCommerceController'
    ]);

    Route::get('/sales', [
        'as' => 'api-get-sales',
        'uses' => 'Api\GetSalesByCommerceController'
    ]);

    Route::get('/payments', [
        'as' => 'api-payments',
        'uses' => 'Api\GetPaymentsCommerceController'
    ]);

    Route::post('/request-payment', [
        'as' => 'api-request-payment',
        'uses' => 'Api\RequestPaymentController'
    ]);

    Route::get('/order/{order}/update', [
        'as' => 'api-update-order',
        'uses' => 'Api\UpdateStatusController'
    ]);

    Route::post('/create/account', [
        'as' => 'api-commerce-create-account',
        'uses' => 'Api\CreateAccountController'
    ]);

    Route::get('/detail/account', [
        'as' => 'api-commerce-detail-account',
        'uses' => 'Api\DetailAccountController'
    ]);
});

Route::group(['prefix' => 'products'], function () {
    Route::get('/categories', [
        'as' => 'api-categories',
        'uses' => 'Api\CategoriesController'
    ]);

    Route::get('/sales/address/{address}', [
        'as' => 'api-sales',
        'uses' => 'Api\SalesController'
    ]);

    Route::post('/calculate-delivery', [
        'as' => 'calculate-delivery',
        'uses' => 'Api\CalculateDeliveryAmountController'
    ]);

    Route::post('/create-order/address/{address}', [
        'as' => 'create-order',
        'uses' => 'Api\CreateOrderController'
    ]);

    Route::get('/category/{category}/address/{address}', [
        'as' => 'api-category',
        'uses' => 'Api\ProductCategoryController'
    ]);

    Route::get('/store/{store}/address/{address}', [
        'as' => 'api-store',
        'uses' => 'Api\ProductStoreController'
    ]);

    Route::get('/featured/address/{address}', [
        'as' => 'api-featured',
        'uses' => 'Api\FeaturedController'
    ]);

    Route::get('/valid/categories', [
        'as' => 'api-valid-categories',
        'uses' => 'Api\CategoryController'
    ]);

    Route::get('/stores/address/{address}', [
        'as' => 'api-stores',
        'uses' => 'Api\StoreController'
    ]);

    Route::get('/category/{category}', [
        'as' => 'api-products-categories',
        'uses' => 'Api\ProductsByCategoryAndCommerceController'
    ]);

    Route::post('/commerce/create', [
        'as' => 'api-products-commerce-create',
        'uses' => 'Api\CreateProductCommerceController'
    ]);
});
