<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
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
Route::post("/logout", [UserController::class, 'logout'])->name("logout");
Route::post("/", [TransactionController::class, 'addToCart'])->name("addToCart");
Route::put("/", [TransactionController::class, 'payProduct'])->name("payProduct");
Route::get("/", [UserController::class, 'index']);
