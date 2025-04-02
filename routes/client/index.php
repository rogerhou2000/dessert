<?php

use App\Http\Controllers\Client\ClientController;
use Illuminate\Support\Facades\Route;
Route::group([ "prefix" => "client","middleware"=>"member"], function () {
Route::get("/index",[ClientController::class,"index"]);
Route::post("/submit",[ClientController::class,"submitSale"]);
Route::get("/book", [ClientController::class, "book"]); 
Route::get("/clientBook", [ClientController::class, "clientBook"]); 
});
