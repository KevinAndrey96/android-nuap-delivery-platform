<?php

use App\Http\Middleware\ValidateJWT;
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

    Route::middleware([ValidateJWT::class])->get('/location', [
        'as' => 'api-users-location',
        'uses' => 'Api\LocationController'
    ]);

    Route::middleware([ValidateJWT::class])->post('/location/create', [
        'as' => 'api-users-location-create',
        'uses' => 'Api\CreateLocationController'
    ]);

    Route::middleware([ValidateJWT::class])->get('/location/{address_id}/delete', [
        'as' => 'api-users-location-delete',
        'uses' => 'Api\DeleteLocationController'
    ]);

    Route::middleware([ValidateJWT::class])->post('/ticket/create', [
        'as' => 'api-ticket-create',
        'uses' => 'Api\CreateTicketController'
    ]);

    Route::middleware([ValidateJWT::class])->post('/ticket/reply', [
        'as' => 'api-users-ticket-reply',
        'uses' => 'Api\ReplyTicketController'
    ]);

    Route::middleware([ValidateJWT::class])->get('/ticket/{ticket}/messages', [
        'as' => 'api-users-ticket-messages',
        'uses' => 'Api\GetMessagesFromTicketController'
    ]);

    Route::middleware([ValidateJWT::class])->get('/ticket', [
        'as' => 'api-users-ticket',
        'uses' => 'Api\GetTicketByUserController'
    ]);

    Route::middleware([ValidateJWT::class])->get('/profile', [
        'as' => 'api-users-profile',
        'uses' => 'Api\ProfileUserController'
    ]);

    Route::middleware([ValidateJWT::class])->post('/profile/edit', [
        'as' => 'api-users-edit-profile',
        'uses' => 'Api\EditUserProfileController'
    ]);

    Route::middleware([ValidateJWT::class])->get('/orders', [
        'as' => 'api-users-orders',
        'uses' => 'Api\GetOrdersByUserController'
    ]);

    Route::middleware([ValidateJWT::class])->get('/orders/{order}/products', [
        'as' => 'api-users-orders-products',
        'uses' => 'Api\GerProductsByOrderController'
    ]);

    Route::middleware([ValidateJWT::class])->get('/seller/{seller}/info', [
        'as' => 'api-users-seller',
        'uses' => 'Api\SellerInfoController'
    ]);

    Route::middleware([ValidateJWT::class])->post('/rating', [
        'as' => 'api-rating',
        'uses' => 'Api\RatingOrderController'
    ]);
});

Route::group(['prefix' => 'commerces'], function () {
    Route::middleware([ValidateJWT::class])->get('/profile', [
        'as' => 'api-commerces-profile',
        'uses' => 'Api\ProfileCommerceController'
    ]);

    Route::middleware([ValidateJWT::class])->get('/sales', [
        'as' => 'api-get-sales',
        'uses' => 'Api\GetSalesByCommerceController'
    ]);

    Route::middleware([ValidateJWT::class])->get('/payments', [
        'as' => 'api-payments',
        'uses' => 'Api\GetPaymentsCommerceController'
    ]);

    Route::middleware([ValidateJWT::class])->post('/request-payment', [
        'as' => 'api-request-payment',
        'uses' => 'Api\RequestPaymentController'
    ]);

    Route::middleware([ValidateJWT::class])->get('/order/{order}/update', [
        'as' => 'api-update-order',
        'uses' => 'Api\UpdateStatusController'
    ]);

    Route::middleware([ValidateJWT::class])->post('/create/account', [
        'as' => 'api-commerce-create-account',
        'uses' => 'Api\CreateAccountController'
    ]);

    Route::middleware([ValidateJWT::class])->get('/detail/account', [
        'as' => 'api-commerce-detail-account',
        'uses' => 'Api\DetailAccountController'
    ]);
});

Route::group(['prefix' => 'products'], function () {
    Route::middleware([ValidateJWT::class])->get('/categories', [
        'as' => 'api-categories',
        'uses' => 'Api\CategoriesController'
    ]);

    Route::middleware([ValidateJWT::class])->get('/sales/address/{address}', [
        'as' => 'api-sales',
        'uses' => 'Api\SalesController'
    ]);

    Route::middleware([ValidateJWT::class])->post('/calculate-delivery', [
        'as' => 'calculate-delivery',
        'uses' => 'Api\CalculateDeliveryAmountController'
    ]);

    Route::middleware([ValidateJWT::class])->post('/create-order/address/{address}', [
        'as' => 'create-order',
        'uses' => 'Api\CreateOrderController'
    ]);

    Route::middleware([ValidateJWT::class])->get('/category/{category}/address/{address}', [
        'as' => 'api-category',
        'uses' => 'Api\ProductCategoryController'
    ]);

    Route::middleware([ValidateJWT::class])->get('/store/{store}/address/{address}', [
        'as' => 'api-store',
        'uses' => 'Api\ProductStoreController'
    ]);

    Route::middleware([ValidateJWT::class])->get('/featured/address/{address}', [
        'as' => 'api-featured',
        'uses' => 'Api\FeaturedController'
    ]);

    Route::middleware([ValidateJWT::class])->get('/valid/categories', [
        'as' => 'api-valid-categories',
        'uses' => 'Api\CategoryController'
    ]);

    Route::middleware([ValidateJWT::class])->get('/stores/address/{address}', [
        'as' => 'api-stores',
        'uses' => 'Api\StoreController'
    ]);

    Route::middleware([ValidateJWT::class])->get('/category/{category}', [
        'as' => 'api-products-categories',
        'uses' => 'Api\ProductsByCategoryAndCommerceController'
    ]);

    Route::middleware([ValidateJWT::class])->post('/commerce/create', [
        'as' => 'api-products-commerce-create',
        'uses' => 'Api\CreateProductCommerceController'
    ]);
});
