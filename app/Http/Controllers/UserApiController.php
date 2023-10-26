<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class UserApiController extends Controller
{
    public function postLogin(Request $request)
    {
        $validate = $request->validate([
            "name" => "required",
            "password" => "required",
        ]);
        $token = User::where("name", $request->name)->first()->createToken('auth')->plainTextToken;

        if (!Auth::attempt($validate)) return response()->json([
            'message' => 'wrong username or password',
            'data' => $validate
        ], 404);

        if (Auth::user()->roles_id == 1) return response()->json([
            'message' => 'success login admin',
            'data' => $validate,
            'token' => $token
        ], 200);

        if (Auth::user()->roles_id == 2) return response()->json([
            'message' => 'success login kantin',
            'data' => $validate,
            'token' => $token
        ], 200);

        if (Auth::user()->roles_id == 3) return response()->json([
            'message' => 'success login bank',
            'data' => $validate,
            'token' => $token
        ], 200);


        return response()->json([
            'message' => 'success login siswa',
            'data' => $validate,
            'token' => $token
        ], 200);
    }

    public function registerUser(Request $request)
    {
        $user = User::create([
            "name" => $request->name,
            "password" => bcrypt($request->password),
            "roles_id" => 1
        ]);

        return response()->json([
            'message' => 'success register siswa',
            'data' => $user
        ], 200);
    }

    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout success',
        ], 200);
    }

    public function index(Request $request)
    {
        if (!Auth::user()) return response()->json([
            'message' => 'not logged in',
        ], 200);

        $transactionsKeranjang = Transaction::with("products")->where("users_id", Auth::user()->id)->where("status", "dikeranjang")->get();
        $transactionsBayar = Transaction::with("products")->where("users_id", Auth::user()->id)->where("status", "dibayar")->get();

        $wallets = Wallet::with("user")->get();
        $wallet_count = Wallet::with("user")->where("status", "selesai")->count();
        $wallet_bank = Wallet::with("user")->where("status", "selesai")->get();

        $user = Auth::user();
        $users = User::with("roles")->get();
        $nasabah = User::where("roles_id", "4")->count();
        $products = Product::with("transaction")->get();

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

        if ($user->roles_id == 1) return response()->json([
            'message' => 'success get data admin',
            'user' => $user,
            'wallet' => $wallet,
            'balance' => $difference,
            'products' => $products,
            'transactionsKeranjang' => $transactionsKeranjang,
            'transactionsBayar' => $transactionsBayar,
            'users' => $users
        ], 200);

        if ($user->roles_id == 2) return response()->json([
            'message' => 'success get data kantin',
            'user' => $user,
            'wallet' => $wallet,
            'balance' => $difference,
            'products' => $products,
            'transactionsKeranjang' => $transactionsKeranjang,
            'transactionsBayar' => $transactionsBayar
        ], 200);

        if ($user->roles_id == 3) return response()->json([
            'message' => 'success get data bank',
            'user' => $user,
            'wallets' => $wallets,
            'balanceBank' => $difference_bank,
            'nasabah' => $nasabah,
            'walletCount' => $wallet_count,
        ], 200);

        return response()->json([
            'message' => 'success get data user',
            'user' => $user,
            'wallet' => $wallet,
            'balance' => $difference,
            'products' => $products,
            'transactionsKeranjang' => $transactionsKeranjang,
            'transactionsBayar' => $transactionsBayar
        ], 200);
    }
}
