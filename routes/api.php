<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Models\Notification;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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


Route::prefix("v1")->group(function () {
    
    Route::prefix("auth")->group(function () {
        Route::controller(AuthController::class)->group(function() {
          Route::post("register", "register");
          Route::post("login", "login");
        });
    });

    Route::middleware("auth:api")->group(function() {
       Route::prefix("user")->controller(UserController::class)->group(function() {
          Route::get("/","getUser");
          Route::get("/all","getAllUser");
          Route::get("{parameterId}", "getUserByPhonenumberOrId");
          Route::put("/","updateUser");
          Route::post("pin", "validatePinUser");
          Route::put("pin","setPin");
       });

       Route::prefix("transaction")->controller(TransactionController::class)->group(function() {
          Route::get("/", "getDataTransactionUser");
          Route::post("/", "createTransaction");
          Route::post("topup", "topUpSaldo");
       });

       Route::prefix("notification")->controller(NotificationController::class)->group(function() {
          Route::get("/", "getNotification");
       });

       Route::prefix("log")->controller(LogController::class)->group(function() {
          Route::get("/", "getLog");
       });

    });

});
