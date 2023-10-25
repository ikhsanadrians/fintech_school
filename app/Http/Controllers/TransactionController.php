<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserTransaction;
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
        $transactionsKeranjang = Transaction::with("products")->where("users_id", Auth::user()->id)->where("status", "dikeranjang")->get();
        $laporanPembayaran = Transaction::with("products")->where("users_id", Auth::user()->id)->where("status", "dibayar")->get()->groupBy('order_code');
        $transactionsBayar = Transaction::with("products")->where("users_id", Auth::user()->id)->where("status", "dibayar")->get();
        $walletSelesai = Wallet::where("users_id", Auth::user()->id)->where("status", "selesai")->get();
        $walletProcess = Wallet::where("users_id", Auth::user()->id)->where("status", "process")->get();
        $creditTotal = $walletSelesai->sum('credit');
        $debitTotal = $walletSelesai->sum('debit');
        $difference = $creditTotal - $debitTotal;

        return view("history", compact("transactionsKeranjang", "transactionsBayar", "difference", "laporanPembayaran", "walletProcess", "walletSelesai"));
    }

    public function transactionList()
    {
        $transactions = Transaction::with("products", "user", "userTransactions")->get();

        return view("transaction", compact("transactions"));
    }

    public function downloadAll(Request $request)
    {
        $category = $request->index;

        if ($category == "") {
            $transactions = Transaction::with("products", "user", "userTransactions")->get();
        } else {
            $transactions = Wallet::all();
        }

        return view("downloadall", compact("transactions", "category"));
    }

    public function reportList()
    {
        $laporanPembayaran = Transaction::where("status", "dibayar")->get()->groupBy('order_code');

        return view('report', compact("laporanPembayaran"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function payProduct()
    {
        $order_code = "INV_" . Auth::user()->id . now()->format("dmYHis");
        $transactionKeranjang = Transaction::with("products")->where("users_id", Auth::user()->id)->where("status", "dikeranjang")->get();
        $wallet = Wallet::where("users_id", Auth::user()->id)->first();
        $totalBayar = 0;
        foreach ($transactionKeranjang as $ts) {
            $totalBayar += ($ts->price * $ts->quantity);
        }
        Transaction::where("users_id", Auth::user()->id)
            ->where("status", "dikeranjang")
            ->update([
                'status' => 'dibayar',
                'order_code' => $order_code
            ]);
        $wallet->update([
            'debit' => $wallet->debit + $totalBayar,
        ]);

        return redirect()->back();
    }

    public function payNow(Request $request, $id)
    {
        $order_code = "INV_" . Auth::user()->id . now()->format("dmYHis");
        $wallet = Wallet::where("users_id", Auth::user()->id)->find(2);

        Transaction::create([
            "users_id" => Auth::user()->id,
            "products_id" => $id,
            "status" => "dibayar",
            "order_code" => $order_code,
            "price" => $request->price,
            "quantity" => $request->quantity
        ]);

        $wallet->update([
            'debit' => $wallet->debit + ($request->price * $request->quantity)
        ]);

        return redirect()->back();
    }

    public function cancelCart(Request $request)
    {
        $transactionKeranjang = Transaction::with("products", "userTransactions")->where("users_id", Auth::user()->id)->where("status", "dikeranjang")->where("id", $request->id);
        $transactionKeranjang->delete();

        return redirect()->back();
    }

    public function clearHistoryBuy()
    {
        $transactionsBayar = Transaction::with("products")->where("users_id", Auth::user()->id)->where("status", "dibayar");
        $transactionsBayar->delete();

        return redirect()->back();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function addToCart(Request $request)
    {
        $order_code = "INV_" . Auth::user()->id . now()->format("dmYHis");
        $same_transaction = Transaction::where("products_id", $request->products_id)->where("users_id", Auth::user()->id)->where("status", "dikeranjang")->first();
        $product = Product::find($request->products_id);
        if ($same_transaction) {
            $sum_quantity = $same_transaction->quantity += $request->quantity;
            $sum_price = $sum_quantity * $product->price;
            $same_transaction->update([
                "quantity" => $sum_quantity,
                "price" => $sum_price
            ]);
        } else {
            $transaction = Transaction::create([
                "users_id" => Auth::user()->id,
                "products_id" => $request->products_id,
                "status" => "dikeranjang",
                "order_code" => $order_code,
                "price" => $request->price,
                "quantity" => $request->quantity
            ]);

            UserTransaction::create([
                "user_id" => $transaction->users_id,
                "transaction_id" => $transaction->id
            ]);
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function downloadReport($order_code)
    {
        $report = Transaction::with("products")->where("order_code", $order_code)->get();
        $code = $order_code;

        return view('download', compact('report', 'code'));
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
