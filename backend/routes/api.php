<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('products',ProductController::class);
Route::apiResource('categories',CategoryController::class);

Route::get('/images/products/{filename}', function ($filename) {
    $path = 'public/products/images/' . $filename;
    if (Storage::exists($path)) {
        return Storage::response($path);
    } else {
        abort(404);
    }
})->where('filename', '.*');
