<?php

use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Front\FrontController;
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
Route::get("/getType", [FrontController::class, "getType"]);
Route::get("/getProduct", [FrontController::class, "getProduct"]);
Route::get("/getSale/{id}", [ClientController::class, "findBook"]);
Route::group(["middleware" => "auth:sanctum"], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});