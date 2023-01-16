<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('StoreImageFileController', 'StoreImageFileController@createFile');

Route::put('re_update_property_owner/{id}', 'ApiController@updatePropertyOwnerData');
Route::put('re_update_property_type/{id}', 'ApiController@updatePropertyTypeData');
Route::put('re_update_property_category/{id}', 'ApiController@updatePropertyCategoryData');
Route::delete('re_delete_property_category/{id}', 'ApiController@deletePropertyCategoryData');
Route::delete('re_delete_property_type/{id}', 'ApiController@deletePropertyTypeData');
Route::post('save_property_from_mobile', 'ApiController@savePropertyFromMobile');
Route::put('update_property_from_mobile/{property}/{owner}', 'ApiController@updatePropertyFromMobile');
Route::post('check_auth_system', 'ApiController@checkMobileAuth');
Route::post('request_payment', 'ApiController@postPayment');
Route::post('editpayment', 'ApiController@editPayment');
Route::get('return/payments/{id}/{clt}', 'ApiController@returnPaymentBills');
Route::get('fetch/payments/{id}', 'ApiController@fetchPaymentBill');



Route::put('re_update_business_owner/{id}', 'BusinessApiController@updateBusinessOwnerData');
Route::put('re_update_business_type/{id}', 'BusinessApiController@updateBusinessTypeData');
Route::put('re_update_business_category/{id}', 'BusinessApiController@updateBusinessCategoryData');
Route::delete('re_delete_business_category/{id}', 'BusinessApiController@deleteBusinessCategoryData');
Route::delete('re_delete_business_type/{id}', 'BusinessApiController@deleteBusinessTypeData');
Route::post('save_business_from_mobile', 'BusinessApiController@saveBusinessFromMobile');
Route::put('update_business_from_mobile/{business}/{owner}', 'BusinessApiController@updateBusinessFromMobile');
Route::post('check_auth_system', 'ApiController@checkMobileAuth');


Route::get('get/bill/count/{account}', 'ApiController@getBilCount');
Route::get('get/bill/set/{account}', 'ApiController@getBilSet');
Route::post('get/bulkbill/set/{account}', 'ApiController@getBilSetBulk');
Route::get('/update/print/status', 'ApiController@updateBill');
