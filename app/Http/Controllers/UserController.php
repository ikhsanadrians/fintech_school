<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function postLogin(Request $request)
    {
        $validate = $request->validate([
            "name" => "required",
            "password" => "required",
        ]);

        if (!Auth::attempt($validate)) return redirect()->back();

        return redirect("/");
    }

    public function getLogin()
    {
        return view("login");
    }

    public function registerUser(Request $request)
    {
        User::create([
            "name" => $request->name,
            "password" => bcrypt($request->password)
        ]);

        return redirect("/login");
    }

    public function getRegisterUser()
    {
        return view("register");
    }

    public function index()
    {
        if (!Auth::user()) return view("dashboard");

        $transactionsKeranjang = Transaction::with("products")->where("users_id", Auth::user()->id)->where("status", "dikeranjang")->get();
        $transactionsBayar = Transaction::with("products")->where("users_id", Auth::user()->id)->where("status", "dibayar")->get();

        $user = Auth::user();
        $products = Product::all();
        $wallet = Wallet::where("users_id", Auth::user()->id)->where("status", "selesai")->get();
        // dd($wallet);
        $creditTotal = $wallet->sum('credit');
        $debitTotal = $wallet->sum('debit');
        $difference = $creditTotal - $debitTotal;

        return view("home", compact("user", "wallet", "difference", "products", "transactionsKeranjang", "transactionsBayar"));
    }

    public function logout()
    {
        Session::flush();
        Auth::user();
        return view("dashboard");
    }
}
