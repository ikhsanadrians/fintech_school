<?php

namespace App\Http\Controllers;

use App\Models\Category;
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

        if (Auth::user()->roles_id == 1) return redirect("/admin");
        if (Auth::user()->roles_id == 2) return redirect("/kantin");
        if (Auth::user()->roles_id == 3) return redirect("/bank");

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
            "password" => bcrypt($request->password),
            "roles_id" => 1
        ]);

        return redirect("/login");
    }

    public function getRegisterUser()
    {
        return view("register");
    }

    public function index(Request $request)
    {
        if (!Auth::user()) return view("dashboard");

        $transactionsKeranjang = Transaction::with("products")->where("users_id", Auth::user()->id)->where("status", "dikeranjang")->get();
        $transactionsBayar = Transaction::withTrashed()->with("products")->where("users_id", Auth::user()->id)->where("status", "dibayar")->get();
        $categories = Category::all();

        $wallets = Wallet::with("user")->get();
        $wallet_count = Wallet::with("user")->where("status", "selesai")->count();
        $wallet_bank = Wallet::with("user")->where("status", "selesai")->get();

        $user = Auth::user();
        $users = User::with("roles")->get();
        $nasabah = User::where("roles_id", "4")->count();
        $products = Product::with("transaction")->get();
        $product_hapus = Product::whereHas("transaction", function ($query) {
            $query->where("status", "dikeranjang");
        })->with("transaction")->withTrashed()->get();

        $wallet = Wallet::where("users_id", Auth::user()->id)->where("status", "selesai")->get();
        $creditTotal = $wallet->sum('credit');
        $debitTotal = $wallet->sum('debit');

        $credit_bank = $wallet_bank->sum('credit');
        $debit_bank = $wallet_bank->sum('debit');

        $difference = $creditTotal - $debitTotal;
        $difference_bank = $credit_bank - $debit_bank;
        $filter = $request->filter;
        $category = $request->category;

        if ($category == '' || $category == 'null') {
            $products = Product::with('transaction')->orderBy("name", $filter == '' || $filter == 'null' ? 'asc' : $filter)->get();
        } else {
            $products = Product::with('transaction')->where("categories_id", $category == '' || $category == 'null' ? '1' : $category)->orderBy("created_at", $filter == '' || $filter == 'null' ? 'asc' : $filter)->get();
        }

        if ($user->roles_id == 1) return view("admin", compact("user", "wallet", "difference", "products", "transactionsKeranjang", "transactionsBayar", "users"));
        if ($user->roles_id == 2) return view("kantin", compact("user", "wallet", "difference", "products", "transactionsKeranjang", "transactionsBayar", "categories"));
        if ($user->roles_id == 3) return view("bank", compact("wallets", "difference_bank", "nasabah", "wallet_count"));

        return view("home", compact("user", "wallet", "difference", "products", "transactionsKeranjang", "transactionsBayar", "product_hapus"));
    }

    public function logout()
    {
        Session::flush();
        Auth::user();
        return view("dashboard");
    }
}
