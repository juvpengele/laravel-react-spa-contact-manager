<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\{ RegisterController};

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/", function() {
    return response()->json([
        "status" => "Application is running"
    ], 200);
});

Route::group(["prefix" => "auth"], function() {
    Route::post("register", [RegisterController::class, "store"])->name("auth.register");
    Route::post("confirm", [RegisterController::class, "confirm"])->name("auth.confirm");
});
