<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CarModelController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ColorController;
use App\Http\Controllers\Api\ContactUsController;
use App\Http\Controllers\Api\PanelingController;
use App\Http\Controllers\Api\PanelingSpecificationController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\OrderController;
use App\Models\Category;
use App\Models\PanelingSpecification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Twilio\TwiML\Video\Room;

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
// Route::get('/categories',[CategoryController::class,'index']);
// Route::post('/categories')
Route::post('/login', [AuthController::class, 'login']);

// Admin Routes



// Employee Routes
Route::middleware(['auth:api', 'employee'])->group(function () {
    Route::get('/employee/dashboard', function () {
        return response()->json(['message' => 'Employee Dashboard']);
    });
});

// Delivery Routes
Route::middleware(['auth:api', 'delivery'])->group(function () {
    Route::get('/delivery/orders', function () {
        return response()->json(['message' => 'Delivery Orders']);
    });
});
Route::middleware(['auth:api', 'admin'])->group(function () {
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('brands', BrandController::class);
    Route::apiResource('models',CarModelController::class);
    Route::apiResource('colors',ColorController::class);
    Route::apiResource('panelings',PanelingController::class);
    Route::apiResource('specifications',PanelingSpecificationController::class);
    Route::get('contact-us',[ContactUsController::class,'index']);
});
Route::get('orders',[OrderController::class,'getAllOrder']);
Route::get('orders/{id}',[OrderController::class,'showOrderDashboard']);
Route::delete('orders/{id}',[OrderController::class,'deleteOrderDashboard']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


