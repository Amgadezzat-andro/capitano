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


Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// !! Employee Routes
Route::middleware(['employee'])->group(function () {
    Route::get('/employee/dashboard', function () {
        return response()->json(['message' => 'Employee Dashboard']);
    });
});

// !! Delivery Routes
Route::middleware(['delivery'])->group(function () {
    Route::get('/delivery/orders', function () {
        return response()->json(['message' => 'Delivery Orders']);
    });
});

// !! Dashboard Routes
Route::middleware(['admin'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('brands', BrandController::class);
    Route::apiResource('models', CarModelController::class);
    Route::apiResource('colors', ColorController::class);
    Route::apiResource('panelings', PanelingController::class);
    Route::apiResource('specifications', PanelingSpecificationController::class);
   // Pgination for specifications
    Route::get('specifications-paginate', [PanelingSpecificationController::class, 'GetAllPaginate']);
    Route::get('brands-paginate', [BrandController::class, 'GetAllPaginate']);
    Route::get('panelings-paginate', [PanelingController::class, 'GetAllPaginate']);
    Route::get('categories-paginate', [CategoryController::class, 'GetAllPaginate']);
    Route::get('models-paginate', [CarModelController::class, 'GetAllPaginate']);

    Route::get('contact-us-admin', [ContactUsController::class, 'index']);
    Route::get('orders', [OrderController::class, 'getAllOrder']);
    Route::get('orders/{id}', [OrderController::class, 'showOrderDashboard']);
    Route::delete('orders/{id}', [OrderController::class, 'deleteOrderDashboard']);
});






