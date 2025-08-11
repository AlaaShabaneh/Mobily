<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\WarrantyClaimController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\DeviceListingController;
use App\Http\Controllers\DeviceRatingController;
use App\Http\Controllers\DeviceSpecificationValueController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\SpecificationController;
use App\Http\Controllers\StockEntryController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\WarrantyCompanyController;
use App\Http\Controllers\WarrantyDetailController;
use App\Http\Controllers\WarrantyRatingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\DeviceSerialController;
use App\Http\Controllers\DeviceVariantController;
use App\Http\Controllers\DeviceVariantSpecificationController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/users', [UserController::class, 'store']);

Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
    
});

Route::apiResource('device-variants', DeviceVariantController::class);

Route::apiResource('device-variant-specifications', DeviceVariantSpecificationController::class);

Route::apiResource('orders', OrderController::class);
Route::apiResource('order-statuses', OrderStatusController::class);
Route::apiResource('providers', ProviderController::class);
Route::apiResource('warranty-claims', WarrantyClaimController::class);
Route::apiResource('brands', BrandController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('credits', CreditController::class);
Route::apiResource('device-listings', DeviceListingController::class);
Route::apiResource('device-ratings', DeviceRatingController::class);
Route::apiResource('device-specification-values', DeviceSpecificationValueController::class);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('favorites/add', [FavoriteController::class, 'add']);
    Route::post('favorites/remove', [FavoriteController::class, 'remove']);
    Route::get('favorites', [FavoriteController::class, 'list']);
});
Route::prefix('devices/{device}')->group(function () {
    Route::get('images', [ImageController::class, 'index']);
    Route::post('images', [ImageController::class, 'store']);
});
Route::delete('images/{id}', [ImageController::class, 'destroy']);
Route::apiResource('models', ModelController::class);
Route::apiResource('prices', PriceController::class);
Route::apiResource('specifications', SpecificationController::class);
Route::apiResource('stock-entries', StockEntryController::class);
Route::apiResource('types', TypeController::class);
Route::apiResource('warranty-companies', WarrantyCompanyController::class);
Route::apiResource('warranty-details', WarrantyDetailController::class);
Route::apiResource('warranty-ratings', WarrantyRatingController::class);

Route::apiResource('device-serials', DeviceSerialController::class);
Route::get('device-serials/search', [DeviceSerialController::class, 'search']);
