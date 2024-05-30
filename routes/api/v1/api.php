<?php

use Illuminate\Support\Facades\Route;
use App\WebSockets\Handler\DMLocationSocketHandler;
use BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter;
use App\Http\Controllers\Api\DeliveryMan\AmountRequestController;
use App\Http\Controllers\Api\V1\Deliveryman\AuthController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Api\V1\User\OrderController;

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


///config
Route::post('add_slots', [ConfigController::class,'storeSlots']);
Route::put('update_slots', [ConfigController::class,'updateSlot']);
Route::delete('delete_slot', [ConfigController::class,'deleteSlot']);
Route::get('get_slot', [ConfigController::class,'getSlots']);


//deliveryman
Route::post('deliveryman/phone_login', [AuthController::class,'phone_login']);
Route::post('deliveryman/mail_login', [AuthController::class,'mail_login']);
Route::post('deliveryman/check_phone', [AuthController::class,'check_exitsting_phone']);
Route::post('deliveryman/check_mail', [AuthController::class,'check_exitsting_mail']);
Route::get('deliveryman/getprofile', [AuthController::class,'getProfile']);
Route::get('get_all_vendors', [AuthController::class,'getAllVendors']);
Route::post('assign-order-categorywise', [AuthController::class,'assignOrderToCategorywiseInVendor']);
Route::post('assign-order-vendor', [AuthController::class,'assignOrderToVendor']);


/// orders

Route::group(['namespace' => 'Api\V1', 'middleware'=>['localization','react']], function () {
    Route::get('zone/list', 'ZoneController@get_zones');
    Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
        Route::post('sign-up', 'CustomerAuthController@register');
        Route::post('login', 'CustomerAuthController@login');
        Route::post('phone-login', 'CustomerAuthController@phone_login');
        Route::post('email-login', 'CustomerAuthController@mail_login');
        Route::post('verify-phone', 'CustomerAuthController@verify_phone');

        Route::post('check-email', 'CustomerAuthController@check_email');
        Route::post('verify-email', 'CustomerAuthController@verify_email');

        Route::post('forgot-password', 'PasswordResetController@reset_password_request');
        Route::post('verify-token', 'PasswordResetController@verify_token');
        Route::put('reset-password', 'PasswordResetController@reset_password_submit');

        Route::post('guest/request','CustomerAuthController@guest_request');

        Route::group(['prefix' => 'delivery-man'], function () {
            Route::post('login', 'DeliveryManLoginController@login');
            Route::post('store', 'DeliveryManLoginController@store');
            Route::post('phone-login', 'DeliveryManLoginController@phone_login');
            Route::post('mail-login', 'DeliveryManLoginController@mail_login');
            Route::post('forgot-password', 'DMPasswordResetController@reset_password_request');
            Route::post('verify-token', 'DMPasswordResetController@verify_token');
            Route::put('reset-password', 'DMPasswordResetController@reset_password_submit');
        });
        Route::group(['prefix' => 'vendor'], function () {
            Route::post('login', 'VendorLoginController@login');
            Route::get('package-view', 'VendorLoginController@package_view');
            Route::post('business_plan', 'VendorLoginController@business_plan');
            Route::post('forgot-password', 'VendorPasswordResetController@reset_password_request');
            Route::post('verify-token', 'VendorPasswordResetController@verify_token');
            Route::put('reset-password', 'VendorPasswordResetController@reset_password_submit');
            Route::post('register','VendorLoginController@register');
        //subscription
        Route::post('package-renew', 'SubscriptionController@package_renew_change_update_api');
        Route::post('subscription/payment/api', 'VendorLoginController@subscription_payment_api')->name('subscription_payment_api');



        });

        //social login(up comming)
        Route::post('social-login', 'SocialAuthController@social_login');
        Route::post('social-register', 'SocialAuthController@social_register');
    });

    Route::group(['prefix' => 'delivery-man'], function () {
        Route::get('last-location', 'DeliverymanController@get_last_location');


        Route::group(['prefix' => 'reviews','middleware'=>['auth:api']], function () {
            Route::get('/{delivery_man_id}', 'DeliveryManReviewController@get_reviews');
            Route::get('rating/{delivery_man_id}', 'DeliveryManReviewController@get_rating');
            Route::post('/submit', 'DeliveryManReviewController@submit_review');
        });
        Route::group(['middleware'=>['dm.api']], function () {
            Route::get('profile', 'DeliverymanController@get_profile');
            Route::get('notifications', 'DeliverymanController@get_notifications');
            Route::put('update-profile', 'DeliverymanController@update_profile');
            Route::post('update-active-status', 'DeliverymanController@activeStatus');
            Route::get('current-orders', 'DeliverymanController@get_current_orders');
            Route::get('latest-orders', 'DeliverymanController@get_latest_orders');
            Route::post('record-location-data', 'DeliverymanController@record_location_data');
            Route::get('all-orders', 'DeliverymanController@get_all_orders');
            Route::get('order-delivery-history', 'DeliverymanController@get_order_history');
            Route::get('order-history', 'DeliverymanController@get_history');
            Route::put('accept-order', 'DeliverymanController@accept_order');
            Route::put('update-order-status', 'DeliverymanController@update_order_status');
            Route::put('update-payment-status', 'DeliverymanController@order_payment_status_update');
            Route::get('order-details', 'DeliverymanController@get_order_details');
            Route::get('order', 'DeliverymanController@get_order');
            Route::put('update-fcm-token', 'DeliverymanController@update_fcm_token');
            // Route::post('assign-vehicle', 'DeliverymanController@assign_vehicle');
            Route::get('dm-shift', 'DeliverymanController@dm_shift');

            Route::get('get-vendors', 'DeliverymanController@get_vendors');
            //Remove account
            Route::delete('remove-account', 'DeliverymanController@remove_account');
            Route::get('get-withdraw-method-list', 'DeliverymanController@withdraw_method_list');
            Route::get('get-disbursement-report', 'DeliverymanController@disbursement_report');


            ///custom disbursement
            Route::post('request-amount', 'DeliverymanController@amountRequest');

            /// bank detail
            Route::post('add-bank', 'DeliverymanController@addBankDetail');


            // Chatting
            Route::group(['prefix' => 'message'], function () {
                Route::get('list', 'ConversationController@dm_conversations');
                Route::get('search-list', 'ConversationController@dm_search_conversations');
                Route::get('details', 'ConversationController@dm_messages');
                Route::post('send', 'ConversationController@dm_messages_store');
            });

            Route::group(['prefix' => 'withdraw-method'], function () {
                Route::get('list', 'DeliverymanController@get_disbursement_withdrawal_methods');
                Route::post('store', 'DeliverymanController@disbursement_withdrawal_method_store');
                Route::post('make-default', 'DeliverymanController@disbursement_withdrawal_method_default');
                Route::delete('delete', 'DeliverymanController@disbursement_withdrawal_method_delete');
            });

            Route::put('send-order-otp', 'DeliverymanController@send_order_otp');


            Route::post('make-collected-cash-payment', 'DeliverymanController@make_payment')->name('make_payment');
            Route::post('make-wallet-adjustment', 'DeliverymanController@make_wallet_adjustment')->name('make_wallet_adjustment');

            Route::get('wallet-payment-list', 'DeliverymanController@wallet_payment_list')->name('wallet_payment_list');
            Route::get('wallet-provided-earning-list', 'DeliverymanController@wallet_provided_earning_list')->name('wallet_provided_earning_list');
        });
    });

    Route::group(['prefix' => 'vendor', 'namespace' => 'Vendor', 'middleware'=>['vendor.api']], function () {
        Route::get('notifications', 'VendorController@get_notifications');
        Route::get('profile', 'VendorController@get_profile');
        Route::post('update-active-status', 'VendorController@active_status');
        Route::get('earning-info', 'VendorController@get_earning_data');
        Route::put('update-profile', 'VendorController@update_profile');
        Route::get('current-orders', 'VendorController@get_current_orders');
        Route::get('completed-orders', 'VendorController@get_completed_orders');
        Route::get('all-orders', 'VendorController@get_all_orders');
        Route::put('update-order-status', 'VendorController@update_order_status');
        Route::get('order-details', 'VendorController@get_order_details');
        Route::get('order', 'VendorController@get_order');
        Route::put('update-fcm-token', 'VendorController@update_fcm_token');
        Route::get('get-basic-campaigns', 'VendorController@get_basic_campaigns');
        Route::put('campaign-leave', 'VendorController@remove_restaurant');
        Route::put('campaign-join', 'VendorController@addrestaurant');
        Route::get('get-withdraw-list', 'VendorController@withdraw_list');
        Route::get('get-products-list', 'VendorController@get_products');
        Route::put('update-bank-info', 'VendorController@update_bank_info');
        Route::post('request-withdraw', 'VendorController@request_withdraw');

        Route::put('update-announcment', 'VendorController@update_announcment');

        Route::post('make-collected-cash-payment', 'VendorController@make_payment')->name('make_payment');
        Route::post('make-wallet-adjustment', 'VendorController@make_wallet_adjustment')->name('make_wallet_adjustment');

        Route::get('wallet-payment-list', 'VendorController@wallet_payment_list')->name('wallet_payment_list');

        //Report
        Route::get('get-expense', 'ReportController@expense_report');
        Route::get('get-transaction-report', 'ReportController@day_wise_report');
        Route::get('get-order-report', 'ReportController@order_report');
        Route::get('get-campaign-order-report', 'ReportController@campaign_order_report');
        Route::get('get-food-wise-report', 'ReportController@food_wise_report');
        Route::get('get-disbursement-report', 'ReportController@disbursement_report');


        Route::get('get-withdraw-method-list', 'VendorController@withdraw_method_list');

        Route::group(['prefix' => 'withdraw-method'], function () {
            Route::get('list', 'WithdrawMethodController@get_disbursement_withdrawal_methods');
            Route::post('store', 'WithdrawMethodController@disbursement_withdrawal_method_store');
            Route::post('make-default', 'WithdrawMethodController@disbursement_withdrawal_method_default');
            Route::delete('delete', 'WithdrawMethodController@disbursement_withdrawal_method_delete');
        });

        Route::get('coupon-list', 'CouponController@list');
        Route::get('coupon-view', 'CouponController@view');
        Route::post('coupon-store', 'CouponController@store')->name('store');
        Route::post('coupon-update', 'CouponController@update');
        Route::post('coupon-status', 'CouponController@status')->name('status');
        Route::post('coupon-delete', 'CouponController@delete')->name('delete');
        Route::post('coupon-search', 'CouponController@search')->name('search');
        Route::get('coupon/view-without-translate', 'CouponController@view_without_translate');



        //remove account
        Route::delete('remove-account', 'VendorController@remove_account');

        // Business setup
        Route::put('update-business-setup', 'BusinessSettingsController@update_restaurant_setup');

        // Reataurant schedule
        Route::post('schedule/store', 'BusinessSettingsController@add_schedule');
        Route::delete('schedule/{restaurant_schedule}', 'BusinessSettingsController@remove_schedule');

        // Attributes
        Route::get('attributes', 'AttributeController@list');

        // Addon
        Route::group(['prefix'=>'addon'], function(){
            Route::get('/', 'AddOnController@list');
            Route::post('store', 'AddOnController@store');
            Route::put('update', 'AddOnController@update');
            Route::get('status', 'AddOnController@status');
            Route::delete('delete', 'AddOnController@delete');
        });

        Route::group(['prefix' => 'delivery-man'], function () {
            Route::post('store', 'DeliveryManController@store');
            Route::get('list', 'DeliveryManController@list');
            Route::get('preview', 'DeliveryManController@preview');
            Route::get('status', 'DeliveryManController@status');
            Route::post('update/{id}', 'DeliveryManController@update');
            Route::delete('delete', 'DeliveryManController@delete');
            Route::post('search', 'DeliveryManController@search');

            Route::get('get-delivery-man-list', 'DeliveryManController@get_delivery_man_list');
            Route::get('assign-deliveryman', 'DeliveryManController@assign_deliveryman');
        });
        // Food
        Route::group(['prefix'=>'product'], function(){
            Route::post('store', 'FoodController@store');
            Route::put('update', 'FoodController@update');
            Route::delete('delete', 'FoodController@delete');
            Route::get('status', 'FoodController@status');
            Route::get('recommended', 'FoodController@recommended');
            Route::POST('search', 'FoodController@search');
            Route::get('reviews', 'FoodController@reviews');
            Route::get('details/{id}', 'FoodController@get_product');


        });

        // POS
        Route::group(['prefix'=>'pos'], function(){
            Route::get('orders', 'POSController@order_list');
            Route::post('place-order', 'POSController@place_order');
            Route::get('customers', 'POSController@get_customers');
        });

        // Chatting
        Route::group(['prefix' => 'message'], function () {
            Route::get('list', 'ConversationController@conversations');
            Route::get('search-list', 'ConversationController@search_conversations');
            Route::get('details', 'ConversationController@messages');
            Route::post('send', 'ConversationController@messages_store');
        });
        Route::put('send-order-otp', 'VendorController@send_order_otp');
    });


    Route::group(['prefix' => 'config'], function () {
        Route::get('/', 'ConfigController@configuration');
        Route::get('/get-zone-id', 'ConfigController@get_zone');
        Route::get('place-api-autocomplete', 'ConfigController@place_api_autocomplete');
        Route::get('distance-api', 'ConfigController@distance_api');
        Route::get('place-api-details', 'ConfigController@place_api_details');
        Route::get('geocode-api', 'ConfigController@geocode_api');
    });
    Route::get('customer/order/cancellation-reasons', 'OrderController@cancellation_reason');
    Route::get('customer/order/send-notification/{order_id}', 'OrderController@order_notification')->middleware('apiGuestCheck');

    Route::group(['prefix' => 'products'], function () {
        Route::get('all', 'ProductController@all_products');
        Route::get('category-products', 'ProductController@category_products');
        Route::get('delivery_times', 'ProductController@deliveryTimes');
        Route::get('addons', 'ProductController@getAddons');
        Route::get('latest', 'ProductController@get_latest_products');
        Route::get('popular', 'ProductController@get_popular_products');
        Route::get('restaurant-popular-products', 'ProductController@get_restaurant_popular_products');
        Route::get('recommended', 'ProductController@get_recommended');
        Route::get('most-reviewed', 'ProductController@get_most_reviewed_products');
        Route::get('set-menu', 'ProductController@get_set_menus');
        Route::get('search', 'ProductController@get_searched_products');
        Route::get('details/{id}', 'ProductController@get_product');
        Route::get('related-products/{food_id}', 'ProductController@get_related_products');
        Route::get('reviews/{food_id}', 'ProductController@get_product_reviews');
        Route::get('rating/{food_id}', 'ProductController@get_product_rating');
        Route::post('reviews/submit', 'ProductController@submit_product_review')->middleware('auth:api');
        Route::get('food-or-restaurant-search', 'ProductController@food_or_restaurant_search');
        Route::get('recommended/most-reviewed', 'ProductController@recommended_most_reviewed');
    });

    Route::group(['prefix' => 'restaurants'], function () {
        Route::get('get-restaurants/{filter_data}', 'RestaurantController@get_restaurants');
        Route::get('latest', 'RestaurantController@get_latest_restaurants');
        Route::get('popular', 'RestaurantController@get_popular_restaurants');
        Route::get('details/{id}', 'RestaurantController@get_details');  // visitor logs
        Route::get('reviews', 'RestaurantController@reviews');
        Route::get('search', 'RestaurantController@get_searched_restaurants');
        Route::get('recently-viewed-restaurants', 'RestaurantController@recently_viewed_restaurants');
        Route::get('get-coupon', 'RestaurantController@get_coupons');

        Route::get('recommended', 'RestaurantController@get_recommended_restaurants');
        Route::get('visit-again', 'RestaurantController@get_visited_restaurants')->middleware('apiGuestCheck');
    });

    Route::group(['prefix' => 'banners'], function () {
        Route::get('/', 'BannerController@get_banners');
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', 'CategoryController@get_categories');
        Route::get('childes/{category_id}', 'CategoryController@get_childes');
        Route::get('products/{category_id}', 'CategoryController@get_products');   // visitor logs
        Route::get('products/{category_id}/all', 'CategoryController@get_all_products');
        Route::get('restaurants/{category_id}', 'CategoryController@get_restaurants');
    });

    Route::group(['prefix' => 'cuisine'], function () {
        Route::get('/', 'CuisineController@get_all_cuisines');
        Route::get('get_restaurants/', 'CuisineController@get_restaurants');
    });

    Route::group(['prefix' => 'customer', 'middleware' => 'auth:api'], function () {
        Route::get('notifications', 'NotificationController@get_notifications');
        Route::get('info', 'CustomerController@info');
        Route::get('update-zone', 'CustomerController@update_zone');
        Route::post('update-profile', 'CustomerController@update_profile');
        Route::post('update-interest', 'CustomerController@update_interest');
        Route::put('cm-firebase-token', 'CustomerController@update_cm_firebase_token');
        Route::get('suggested-foods', 'CustomerController@get_suggested_food');
        //Remove account
        Route::delete('remove-account', 'CustomerController@remove_account');


        ///address
        Route::post('add-address', 'CustomerController@addAddress');

        ///profile
        Route::get('profile/get', 'CustomerController@getProfile');


        //order 
        Route::post('order/add', [OrderController::class,'place_order']);
        Route::get('order/all-orders', [OrderController::class,'orderList']);
        Route::get('order/running', [OrderController::class,'runningOrders']);
        Route::post('order/cancel', [OrderController::class,'cancelOrder']);
        Route::post('cart/delete', [OrderController::class,'removeCart']);


        Route::group(['prefix'=>'loyalty-point'], function() {
            Route::post('point-transfer', 'LoyaltyPointController@point_transfer');
            Route::get('transactions', 'LoyaltyPointController@transactions');
        });

        Route::group(['prefix'=>'wallet'], function() {
            Route::get('transactions', 'WalletController@transactions');
            Route::get('bonuses', 'WalletController@get_bonus');
            Route::post('add-fund', 'WalletController@add_fund');
        });

        Route::group(['prefix' => 'address'], function () {
            Route::get('list', 'CustomerController@address_list');
            Route::post('add', 'CustomerController@add_new_address');
            Route::put('update/{id}', 'CustomerController@update_address');
            Route::delete('delete', 'CustomerController@delete_address');
        });


        // Chatting
        Route::group(['prefix' => 'message'], function () {
            Route::get('list', 'ConversationController@conversations');
            Route::get('search-list', 'ConversationController@get_searched_conversations');
            Route::get('details', 'ConversationController@messages');
            Route::post('send', 'ConversationController@messages_store');
            Route::post('chat-image', 'ConversationController@chat_image');
        });

        Route::group(['prefix' => 'wish-list'], function () {
            Route::get('/', 'WishlistController@wish_list');
            Route::post('add', 'WishlistController@add_to_wishlist');
            Route::delete('remove', 'WishlistController@remove_from_wishlist');
        });


        Route::put('subscription/update_schedule/{subscription}','OrderSubscriptionController@update_schedule');
        Route::get('subscription/{id}/{tab?}','OrderSubscriptionController@show');
        Route::resource('subscription','OrderSubscriptionController');

    });

    Route::group(['prefix' => 'customer', 'middleware' => 'apiGuestCheck'], function () {
        Route::group(['prefix' => 'order'], function () {
            Route::get('list', 'OrderController@get_order_list');
            Route::get('order-subscription-list', 'OrderController@get_order_subscription_list');
            Route::get('running-orders', 'OrderController@get_running_orders');
            Route::get('details', 'OrderController@get_order_details');
            Route::post('place', 'OrderController@place_order');  // visitor logs
            Route::put('cancel', 'OrderController@cancel_order');
            Route::post('refund-request', 'OrderController@refund_request');
            Route::get('refund-reasons', 'OrderController@refund_reasons');
            Route::get('track', 'OrderController@track_order');
            Route::put('payment-method', 'OrderController@update_payment_method');
            Route::put('offline-payment', 'OrderController@offline_payment');
            Route::put('offline-payment-update', 'OrderController@update_offline_payment_info');
        });

        Route::post('food-list','OrderController@food_list');
        Route::get('order-again', 'OrderController@order_again');

        Route::group(['prefix'=>'cart'], function() {
            Route::get('list', 'CartController@get_carts');
            Route::post('add', 'CartController@add_to_cart');
            Route::post('update', 'CartController@update_cart');
            Route::delete('remove-item', 'CartController@remove_cart_item');
            Route::delete('remove', 'CartController@remove_cart');
            Route::post('add-multiple', 'CartController@add_to_cart_multiple');
        });

    });


    Route::group(['prefix' => 'banners'], function () {
        Route::get('/', 'BannerController@get_banners');
    });

    Route::group(['prefix' => 'campaigns'], function () {
        Route::get('basic', 'CampaignController@get_basic_campaigns');
        Route::get('basic-campaign-details', 'CampaignController@basic_campaign_details');
        Route::get('item', 'CampaignController@get_item_campaigns');
    });

    Route::group(['prefix' => 'coupon', 'middleware' => 'auth:api'], function () {
        Route::get('list', 'CouponController@list');
        Route::get('apply', 'CouponController@apply');
    });
    Route::get('coupon/restaurant-wise-coupon', 'CouponController@restaurant_wise_coupon');

    Route::post('newsletter/subscribe','NewsletterController@index');
    Route::get('landing-page', 'ConfigController@landing_page');
    Route::get('react-landing-page', 'ConfigController@react_landing_page');

    Route::get('vehicle/extra_charge', 'ConfigController@extra_charge');
    Route::get('most-tips', 'OrderController@most_tips');
    Route::get('get-vehicles', 'ConfigController@get_vehicles');
    Route::get('get-PaymentMethods', 'ConfigController@getPaymentMethods');
    Route::get('offline_payment_method_list', 'ConfigController@offline_payment_method_list');
});

WebSocketsRouter::webSocket('/delivery-man/live-location', DMLocationSocketHandler::class);


