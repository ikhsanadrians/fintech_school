<?php

use App\Http\Controllers\CategoryApiController;
use App\Http\Controllers\ProductApiController;
use App\Http\Controllers\TransactionApiController;
use App\Http\Controllers\UserApiController;
use App\Http\Controllers\WalletApiController;
use Illuminate\Support\Facades\Route;

Route::post("/login", [UserApiController::class, 'postLogin'])->name("login");
Route::post("/register", [UserApiController::class, 'registerUser'])->name("register");

Route::middleware("auth:sanctum")->group(function () {
    Route::get("/getsiswa", [UserApiController::class, 'index']);
    Route::post("/logout", [UserApiController::class, 'logout'])->name("logout");
    Route::get("/history/{order_code}", [TransactionApiController::class, 'downloadReport']);
    Route::get("/report/all", [TransactionApiController::class, "downloadAll"]);

    Route::post("/addcart", [TransactionApiController::class, 'addToCart'])->name("addToCart");
    Route::put("/payproduct", [TransactionApiController::class, 'payProduct'])->name("payProduct");
    Route::delete("/keranjang/delete/{id}", [TransactionApiController::class, 'cancelCart']);
    Route::get("/history", [TransactionApiController::class, 'index']);
    Route::delete("/history-clear", [TransactionApiController::class, 'clearHistoryBuy'])->name('clearHistoryBuy');
    Route::post("/topup", [WalletApiController::class, "topUp"])->name("topUp");
    Route::get("/category-product", [ProductApiController::class, "allProduct"]);
    Route::get("/product/{id}", [ProductApiController::class, "show"]);

    Route::get("/admin", [UserApiController::class, 'index']);
    Route::get("/report-admin", [TransactionApiController::class, 'reportList']);
    Route::get("/transaction-admin", [TransactionApiController::class, "transactionList"]);
    Route::get("/category-admin", [CategoryApiController::class, "index"]);
    Route::post("/category-admin-store", [CategoryApiController::class, "store"]);
    Route::delete("/category-admin-delete/{id}", [CategoryApiController::class, "destroy"]);
    Route::put("/category-admin-update/{id}", [CategoryApiController::class, "update"]);
    Route::post("/restore-category/{id}", [CategoryApiController::class, "restoreCategory"]);
    Route::delete("/delete-permanent-category/{id}", [CategoryApiController::class, "deletedPermanent"]);
    Route::post("/user-admin-create", [UserApiController::class, "create"]);
    Route::post("/user-admin-store", [UserApiController::class, "store"])->name('storeUser');
    Route::delete("/user-admin-delete/{id}", [UserApiController::class, "destroy"]);
    Route::get("/user-admin-edit", [UserApiController::class, "edit"]);
    Route::put("/user-admin-update/{id}", [UserApiController::class, "update"]);
    Route::post("/user-admin-restore/{id}", [UserApiController::class, "restoreUser"]);
    Route::delete("/user-admin-trash/{id}", [UserApiController::class, "deletedPermanent"]);

    Route::get("/bank", [UserApiController::class, "index"]);
    Route::get("/report-bank", [TransactionApiController::class, 'reportList']);
    Route::put("/topup-success/{id}", [WalletApiController::class, "topUpSuccess"]);

    Route::get("/kantin", [UserApiController::class, 'index']);
    Route::get("/categories", [CategoryApiController::class, 'index']);
    Route::get("/transaction-kantin", [TransactionApiController::class, "transactionList"]);
    Route::post("/create-product", [ProductApiController::class, "store"])->name('storeProduct');
    Route::put("/product-update/{id}", [ProductApiController::class, "update"])->name("updateProduct");
    Route::get("/product-edit/{id}", [ProductApiController::class, "edit"]);
    Route::delete("/delete-product/{id}", [ProductApiController::class, "destroy"])->name('destroyProduct');
    Route::put("/transaction-kantin/{id}", [TransactionApiController::class, "takeOrder"]);
    Route::post("/restore-kantin/{id}", [ProductApiController::class, "restoreProduct"]);
    Route::delete("/delete-permanent-kantin/{id}", [ProductApiController::class, "deletedPermanent"]);
});
