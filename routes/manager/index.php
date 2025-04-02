<?php

use App\Http\Controllers\Manager\ManagerController;
use Illuminate\Support\Facades\Route;
Route::group([ "prefix" => "manager","middleware"=>"manager"], function () {
Route::get("/index",[ManagerController::class,"index"]);

});
require"client.php";
require"product.php";
require"book.php";

