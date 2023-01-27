<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\FeaturesController;
use App\Http\Controllers\SellTypesController;
use App\Http\Controllers\SubCategoriesController;
use App\Http\Controllers\PropertiesController;




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
    return view('welcome');
});
Route::get('/test', function () {
    return view('dashboard');
});
Route::get('/info', function () {
    return view('info');
});
Route::get('/folder', function () {
    return view('sub_categories.infolde');
});
// //***********************Categories Routes */
// Route::get('/categories',[CategoriesController::class,'index'])->name('categories.index');
// Route::get('/categories/new',[CategoriesController::class,'create'])->name('categories.create');
// Route::post('/categories', [CategoriesController::class,'store'])->name('categories.store');


// //******************************* Feature Routes */
// Route::get('/features',[FeaturesController::class,'index'])->name('features.index');
// Route::get('/features/new',[FeaturesController::class,'create'])->name('features.create');
// Route::post('/features', [FeaturesController::class,'store'])->name('features.store');

// //************************************* sell types routes */
// Route::get('/selltypes',[SellTypesController::class,'index'])->name('sell.index');
// Route::get('/selltypes/new',[SellTypesController::class,'create'])->name('sell.create');
// Route::post('/selltypes', [SellTypesController::class,'store'])->name('sell.store');

// //**************************************sub categories  */
// Route::get('/subcategories',[SubCategoriesController::class,'index'])->name('sub.index');
// Route::get('/subcategories/new',[SubCategoriesController::class,'create'])->name('sub.create');
// Route::post('/subcategories', [SubCategoriesController::class,'store'])->name('sub.store');


// //*********************************Properties *************************** */

// Route::get('/properties',[PropertiesController::class,'index'])->name('properties.index');
// Route::get('/properties/new',[PropertiesController::class,'create'])->name('properties.create');
// Route::post('/properties', [PropertiesController::class,'store'])->name('properties.store');














// Route::get('/agents',[UserController::class,'index'])->name('agents.index');
// Route::get('/agents',[UserController::class,'store'])->name('agents.store');
// Route::get('/agents/create',[UserController::class,'create'])->name('agents.create');
// Route::get('/agents/{id}',[UserController::class,'show'])->name('agents.show');
// Route::get('/agents/{id}/edit',[UserController::class,'edit'])->name('agents.edit');
// Route::Put('/agents/{id}',[UserController::class,'update'])->name('agents.update');






require __DIR__.'/auth.php';
