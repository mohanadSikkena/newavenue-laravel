<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\PropertiesController;
use App\Http\Controllers\CustomersController;

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




Route::post('login',[AuthController::class,'loginUser']);
Route::post('admin-register',[AuthController::class,'adminRegister']);

// ***********************get properties */






//******************************User Api  ***************************/

Route::get('properties',[PropertiesController::class,'api_index']);
Route::get('properties/ads',[PropertiesController::class,'api_ads']);

Route::get('properties/most-views',[PropertiesController::class,'api_most_views']);

Route::get('properties/get-by-category',[PropertiesController::class,'api_getByCategory']);

Route::get('properties/search',[PropertiesController::class,'api_search']);

Route::get('agents/{id}/properties',[PropertiesController::class,'api_agent_prop']);

Route::get('primary',[PropertiesController::class,'api_getPrimary']);
Route::get('properties/filter', [PropertiesController::class,'api_filter']);
//********************************************************* */




//*******************************Agent Api ****************************/

Route::post('properties',[PropertiesController::class,'api_store'])->middleware('auth:sanctum');
Route::delete('properties/{id}',[PropertiesController::class,'api_destroy'])->middleware('auth:sanctum');
Route::put('user',[AuthController::class,'update'])->middleware('auth:sanctum');

Route::put('properties/{id}',[PropertiesController::class,'api_update'])->middleware('auth:sanctum');
Route::get('properties/trash',[PropertiesController::class,'api_trash'])->middleware('auth:sanctum');
Route::get('properties/{id}/restore',[PropertiesController::class,'api_restore'])->middleware('auth:sanctum');
Route::get('properties/{id}/delete',[PropertiesController::class,'api_hardDelete'])->middleware('auth:sanctum');
Route::get('agent/profile',[AuthController::class,'profile'])->middleware('auth:sanctum');
//********************************************************* */



//*******************************Admin Api************************ */

Route::get('properties/on-hold',[PropertiesController::class,'api_onHold'])->middleware('auth:sanctum');
Route::get('users',[AuthController::class,'index'])->middleware('auth:sanctum');
Route::get('properties/{id}/accept-onhold',[PropertiesController::class,'api_accept'])->middleware('auth:sanctum');
Route::get('properties/{id}/reject-onhold',[PropertiesController::class,'api_reject'])->middleware('auth:sanctum');
Route::post('register',[AuthController::class,'createUser'])->middleWare('auth:sanctum');
Route::delete('agents/{id}/delete-agent',[AuthController::class,'deleteUser'])->middleWare('auth:sanctum');
Route::post('properties/ad',[PropertiesController::class,'api_add_ad'])->middleWare('auth:sanctum');
Route::delete('properties/ad/{id}/delete',[PropertiesController::class,'api_delete_ad'])->middleWare('auth:sanctum');

//**************************************************************** */

Route::get('properties/{id}',[PropertiesController::class,'api_show']);



Route::get('customer/properties' , [CustomersController::class ,'api_getcustomers_properties' ])->middleWare('auth:sanctum');
Route::get('customer/{id}/favourite',[CustomersController::class,'api_customer_favourite']);
Route::Post('customer/add-to-favourite',[CustomersController::class,'api_add_to_favourite']);
Route::get('customer/create-new-customer',[CustomersController::class,'api_create_customer']);
Route::post('customer/add-customer-property',[CustomersController::class,'api_add_customer_property']);
Route::delete('customers/{id}',[CustomersController::class,'api_delete_customer_property'])->middleWare('auth:sanctum');
