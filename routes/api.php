<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductCategoryController;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
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

Route::prefix('v1')->group(function()
{
    // Public Routes

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/categories', [ProductCategoryController::class, 'index']);
    Route::get('/categories/{id}', [ProductCategoryController::class, 'show']);
    Route::get('/categories/search/{name}', [ProductCategoryController::class, 'search']);

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    // Protected routes

    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::post('/categories', [ProductCategoryController::class, 'store']);
        Route::put('/categories/{id}', [ProductCategoryController::class, 'update']);
        Route::delete('/categories/{id}', [ProductCategoryController::class, 'delete']);

        Route::post('/logout', [AuthController::class, 'logout']);
    });
});
