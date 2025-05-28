<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CarModelController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ContactUsController;
use App\Http\Controllers\Api\PanelingController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\OrderController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('user/send/otp',[UserController::class,'register']);

Route::get('/all-categories',[CategoryController::class,'getAllCat']);
Route::get('/all-brands',[BrandController::class,'getAllBrands']);
Route::get('/all-models',[CarModelController::class,'getAllModels']);
Route::get('/all-panelings', [PanelingController::class,'getAllPanelings']);

Route::get('/products/order/{category_id}',[OrderController::class,'getAllProduct']);
Route::get('/product/order/{product}',[OrderController::class,'getPeoductForOrder']);
Route::get('/products/order/models/{brandId}',[OrderController::class,'getModelOrder']);
Route::get('/contact-us-admin',[ContactUsController::class,'contactUs']);
Route::post('/Contact-Us',[ContactUsController::class,'contactUsForm']);
Route::post('/makeOrder',[OrderController::class,'makeOrder'])->middleware('auth:api');
Route::get('/products-by-category-id/{catId}',[PanelingController::class,'getProductByCatId']);
Route::post('/auth/register',[AuthController::class,'register']);
Route::post('auth/verify-user-email',[AuthController::class,'verifyCustomerEmail']);
Route::get('customer/verify',[AuthController::class,'getToken']);
Route::post('auth/customer/login',[AuthController::class,'loginUser']);
Route::post('auth/resend-email-verification-link',[AuthController::class,'resendVerificationEmailLink']);

