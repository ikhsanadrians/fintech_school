<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::all();

        return view("home", compact("transactions"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function payProduct()
    {
        $transactionKeranjang = Transaction::with("products")->where("users_id", Auth::user()->id)->where("status", "dikeranjang")->get();
        $wallet = Wallet::where("users_id", Auth::user()->id)->find(2);
        $totalBayar = 0;
        foreach ($transactionKeranjang as $ts) {
            $totalBayar .= ($ts->price * $ts->quantity);
        }
        // $debitTotal = $wallet->sum('debit');
        Transaction::where("users_id", Auth::user()->id)
            ->where("status", "dikeranjang")
            ->update(['status' => 'dibayar']);
        // dd($wallet);
        $wallet->update([
            'debit' => $wallet->debit + $totalBayar
        ]);

        return redirect("/");
    }


    /**
     * Store a newly created resource in storage.
     */
    public function addToCart(Request $request)
    {
        $order_code = "INV_" . Auth::user()->id . now()->format("dmYHis");
        $users_id = Auth::user()->id;
        Transaction::create([
            "users_id" => $users_id,
            "products_id" => $request->products_id,
            "status" => "dikeranjang",
            "order_code" => $order_code,
            "price" => $request->price,
            "quantity" => $request->quantity
        ]);

        return redirect("/");
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
