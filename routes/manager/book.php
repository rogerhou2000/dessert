<?php

use App\Http\Controllers\Manager\MbookController;
use Illuminate\Support\Facades\Route;
Route::group([ "prefix" => "manager/book","middleware"=>"manager"], function () {
Route::get("/index",[MbookController::class,"index"]);
Route::get('/clientBook', [MbookController::class, 'clientBook']);
});