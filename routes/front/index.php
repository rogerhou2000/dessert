<?php

use App\Http\Controllers\Front\FrontController;
use Illuminate\Support\Facades\Route;

Route::get("/",[FrontController::class,"index"]);
Route::get("/product/{type}",[FrontController::class,"product"]);
Route::post("/checkonly",[FrontController::class,"chkUniAcc"]);
Route::post("/reg", [FrontController::class, "register"]);
Route::post("/login",[FrontController::class,"login"]);
Route::get("/logout",[FrontController::class,"logout"]);


