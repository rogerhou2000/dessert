<?php


use App\Http\Controllers\Manager\Musercontroller;
use Illuminate\Support\Facades\Route;
Route::group([ "prefix" => "manager/client","middleware"=>"manager"], function () {
Route::get("/index",[Musercontroller::class,"user"]);
Route::get("/getUser",[Musercontroller::class,"userList"]);
Route::post("/updateUserLevel",[Musercontroller::class,"updateUserLevel"]);
});