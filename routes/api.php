<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\PropertiesController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\FeaturesController;
use App\Http\Controllers\LocationsController;
use App\Http\Controllers\SubCategoriesController;
use App\Http\Controllers\LicencesController;

use App\Http\Controllers\AdsController;
use App\Http\Controllers\FinishesController;
use App\Http\Controllers\PrimaryPropertiesController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::apiResource('/test', function(){
//     return 'success';
// })->middleware('auth:sanctum');




//***********************************Auth **************************************** */

Route::post('login',[AuthController::class,'loginUser']);
Route::post('admin-register',[AuthController::class,'adminRegister']);

Route::put('user',[AuthController::class,'update'])->middleware('auth:sanctum');
Route::get('agent/profile',[AuthController::class,'profile'])->middleware('auth:sanctum');
Route::get('users',[AuthController::class,'index'])->middleware('auth:sanctum');
Route::post('register',[AuthController::class,'createUser'])->middleWare('auth:sanctum');
Route::delete('agents/{id}/delete-agent',[AuthController::class,'deleteUser'])->middleWare('auth:sanctum');

// ***********************properties ****************************************** */
Route::get('properties',[PropertiesController::class,'api_index']);
Route::get('properties/most-views',[PropertiesController::class,'api_most_views']);
Route::get('properties/get-by-category/{id}',[SubCategoriesController::class,'api_getByCategory']);
Route::get('properties/search',[PropertiesController::class,'api_search']);
Route::get('agents/{id}/properties',[PropertiesController::class,'api_agent_prop']);
Route::post('properties',[PropertiesController::class,'api_store'])->middleware('auth:sanctum');
Route::delete('properties/{id}',[PropertiesController::class,'api_destroy'])->middleware('auth:sanctum');
Route::put('properties/{id}',[PropertiesController::class,'api_update'])->middleware('auth:sanctum');
Route::get('properties/trash',[PropertiesController::class,'api_trash'])->middleware('auth:sanctum');
Route::get('properties/{id}/restore',[PropertiesController::class,'api_restore'])->middleware('auth:sanctum');
Route::get('properties/{id}/delete',[PropertiesController::class,'api_hardDelete'])->middleware('auth:sanctum');
Route::get('properties/on-hold',[PropertiesController::class,'api_onHold'])->middleware('auth:sanctum');
Route::get('properties/{id}/reject-onhold',[PropertiesController::class,'api_reject'])->middleware('auth:sanctum');
Route::get('properties/{id}/accept-onhold',[PropertiesController::class,'api_accept'])->middleware('auth:sanctum');
Route::get('properties/{id}',[PropertiesController::class,'api_show']);







//*****************************************customer ******************************** */



Route::get('customer/properties' , [CustomersController::class ,'api_getcustomers_properties' ])->middleWare('auth:sanctum');
Route::get('customer/{id}/favourite',[CustomersController::class,'api_customer_favourite']);
Route::Post('customer/add-to-favourite',[CustomersController::class,'api_add_to_favourite']);
Route::get('customer/create-new-customer',[CustomersController::class,'api_create_customer']);
Route::post('customer/add-customer-property',[CustomersController  ::class,'api_add_customer_property']);
Route::delete('customers/{id}',[CustomersController::class,'api_delete_customer_property'])->middleWare('auth:sanctum');




// ***************************Features*********************************

Route::get('features',[FeaturesController::class,'api_index']);

Route::delete('features/{id}/delete',[FeaturesController::class,'api_destroy'])->middleWare('auth:sanctum');
Route::post('features',[FeaturesController::class,'api_store'])->middleWare('auth:sanctum');


// *******************************************Primary********************

Route::get('primary',[PrimaryPropertiesController::class,'api_index']);
Route::post('primary', [PrimaryPropertiesController::class,'api_store'])->middleWare('auth:sanctum');
Route::delete('primary/{id}/delete', [PrimaryPropertiesController::class,'api_destroy'])->middleWare('auth:sanctum');
Route::get('primary/{id}',[PrimaryPropertiesController::class,'api_show']);

//**********************************Locations ************************** */

Route::get('locations/{id}/primary',[LocationsController::class,'api_primary']);
Route::get('locations',[LocationsController::class,'api_index']);
Route::post('locations',[LocationsController::class,'api_store'])->middleWare('auth:sanctum');
Route::delete('locations/{id}/delete',[LocationsController::class,'api_destroy'])->middleWare('auth:sanctum');

//****************************************Categories ************************* */
Route::get('categories',[SubCategoriesController::class,'api_index']);
Route::post('categories',[SubCategoriesController::class,'api_store'])->middleWare('auth:sanctum');
Route::delete('categories/{id}/delete',[SubCategoriesController::class,'api_destroy'])->middleWare('auth:sanctum');

//***************************************Licences ************************************/
Route::get('/licences',[LicencesController::class,'api_index']);
Route::post('/licences',[LicencesController::class,'store'])->middleWare('auth:sanctum');
Route::put('/licences/{id}',[LicencesController::class,'update'])->middleWare('auth:sanctum');
Route::delete('/licences/{id}',[LicencesController::class,'destroy'])->middleWare('auth:sanctum');
//***************************************finishis *************************************** */
Route::get('/finishes',[FinishesController::class,'api_index']);
Route::post('/finishes',[FinishesController::class,'store'])->middleWare('auth:sanctum');
Route::put('/finishes/{id}',[FinishesController::class,'update'])->middleWare('auth:sanctum');
Route::delete('/finishes/{id}',[FinishesController::class,'destroy'])->middleWare('auth:sanctum');


//*******************************************ads ********************** */

Route::get('/ads',[AdsController::class,'api_ads']);

Route::post('/ad',[AdsController::class,'api_add_ad'])->middleWare('auth:sanctum');

Route::delete('/ad/{id}/delete',[AdsController::class,'api_delete_ad'])->middleWare('auth:sanctum');
