<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/login", [UserController::class, 'getlogin']);
Route::post("/login", [UserController::class, 'postLogin'])->name("login");
Route::post("/register", [UserController::class, 'registerUser'])->name("register");
Route::get("/register", [UserController::class, 'getRegisterUser']);
Route::get("/logout", [UserController::class, 'logout'])->name("logout");
Route::post("/", [TransactionController::class, 'addToCart'])->name("addToCart");
Route::put("/", [TransactionController::class, 'payProduct'])->name("payProduct");
Route::delete("/keranjang/delete", [TransactionController::class, 'cancelCart']);
Route::get("/", [UserController::class, 'index']);
Route::get("/admin", [UserController::class, 'index']);
Route::get("/kantin", [UserController::class, 'index']);
Route::get("/history", [TransactionController::class, 'index']);
Route::get("/report-admin", [TransactionController::class, 'reportList']);
Route::get("/report-bank", [TransactionController::class, 'reportList']);
Route::get("/history/{order_code}", [TransactionController::class, 'downloadReport']);
Route::delete("/history", [TransactionController::class, 'clearHistoryBuy'])->name('clearHistoryBuy');
Route::post("/topup", [WalletController::class, "topUp"])->name("topUp");
Route::get("/clothings", [ProductController::class, "clothes"]);
Route::get("/foods", [ProductController::class, "foods"]);
Route::get("/drinks", [ProductController::class, "drinks"]);
Route::get("/product/{id}", [ProductController::class, "show"]);
Route::put("/product-update/{id}", [ProductController::class, "update"]);
Route::post("/product/{id}", [TransactionController::class, "addToCart"]);
Route::get("/transaction-admin", [TransactionController::class, "transactionList"]);
Route::get("/transaction-kantin", [TransactionController::class, "transactionList"]);
Route::get("/report/all", [TransactionController::class, "downloadAll"]);
Route::get("/bank", [UserController::class, "index"]);
Route::put("/product/{id}", [TransactionController::class, "payProduct"]);
Route::put("/topup/{id}", [WalletController::class, "topUpSuccess"]);
Route::get("/create-product", [ProductController::class, "create"]);
Route::post("/create-product", [ProductController::class, "store"])->name('storeProduct');
Route::delete("/delete-product/{id}", [ProductController::class, "destroy"])->name('destroyProduct');
Route::get("/edit-product/{id}", [ProductController::class, "edit"]);
Route::get("/user", [UserController::class, "listUsers"]);
