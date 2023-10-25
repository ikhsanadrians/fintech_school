<?php

use App\Http\Controllers\UserApiController;
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

Route::post("/login", [UserApiController::class, 'postLogin'])->name("login");
Route::post("/register", [UserApiController::class, 'registerUser'])->name("register");
Route::get("/logout", [UserApiController::class, 'logout'])->name("logout");


Route::middleware('user')->group(function () {
    Route::get("/", [UserController::class, 'index']);
    Route::post("/", [TransactionController::class, 'addToCart'])->name("addToCart");
    Route::put("/", [TransactionController::class, 'payProduct'])->name("payProduct");
    Route::delete("/keranjang/delete", [TransactionController::class, 'cancelCart']);
    Route::get("/history", [TransactionController::class, 'index']);
    Route::delete("/history", [TransactionController::class, 'clearHistoryBuy'])->name('clearHistoryBuy');
    Route::post("/topup", [WalletController::class, "topUp"])->name("topUp");
    Route::get("/history/{order_code}", [TransactionController::class, 'downloadReport']);
    Route::get("/category-product", [ProductController::class, "allProduct"]);
    Route::get("/product/{id}", [ProductController::class, "show"]);
    Route::post("/product/{id}", [TransactionController::class, "addToCart"]);
    Route::put("/product/{id}", [TransactionController::class, "payProduct"]);
});
