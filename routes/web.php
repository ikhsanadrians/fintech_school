<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

Route::get("/login", [UserController::class, 'getlogin']);
Route::post("/login", [UserController::class, 'postLogin'])->name("login");
Route::post("/register", [UserController::class, 'registerUser'])->name("register");
Route::get("/register", [UserController::class, 'getRegisterUser']);
Route::get("/logout", [UserController::class, 'logout'])->name("logout");

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

Route::middleware('admin')->group(function () {
    Route::get("/admin", [UserController::class, 'index']);
    Route::get("/report-admin", [TransactionController::class, 'reportList']);
    Route::get("/transaction-admin", [TransactionController::class, "transactionList"]);
});

Route::middleware('bank')->group(function () {
    Route::get("/bank", [UserController::class, "index"]);
    Route::get("/report-bank", [TransactionController::class, 'reportList']);
    Route::put("/topup/{id}", [WalletController::class, "topUpSuccess"]);
    Route::get("/user", [UserController::class, "listUsers"]);
});

Route::middleware('kantin')->group(function () {
    Route::get("/kantin", [UserController::class, 'index']);
    Route::get("/transaction-kantin", [TransactionController::class, "transactionList"]);
    Route::get("/create-product", [ProductController::class, "create"]);
    Route::post("/create-product", [ProductController::class, "store"])->name('storeProduct');
    Route::get("/edit-product/{id}", [ProductController::class, "edit"]);
    Route::put("/product-update/{id}", [ProductController::class, "update"])->name("updateProduct");
    Route::delete("/delete-product/{id}", [ProductController::class, "destroy"])->name('destroyProduct');
});

Route::get("/report/all", [TransactionController::class, "downloadAll"]);
