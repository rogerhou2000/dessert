<?php

use App\Http\Controllers\Manager\MproductController;

use Illuminate\Support\Facades\Route;
Route::group([ "prefix" => "manager/product","middleware"=>"manager"], function () {
Route::get("/index",[MproductController::class,"index"]);
Route::post('/add', [MproductController::class, 'add']);
Route::post('/update', [MproductController::class, 'update']);
Route::delete('/delete/{id}', [MproductController::class, 'delete']);

});