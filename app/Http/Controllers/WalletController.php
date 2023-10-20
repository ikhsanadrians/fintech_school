<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wallets = Wallet::with("user")->get();

        return view("bank", compact("wallets"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function topUp(Request $request)
    {
        $user = Auth::user()->id;

        Wallet::create([
            "users_id" => $user,
            "credit" => $request->credit,
            "status" => "process"
        ]);

        return redirect()->back();
    }

    public function topUpSuccess($id)
    {
        $wallet = Wallet::find($id);

        $wallet->update([
            "status" => "selesai"
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Wallet $wallet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wallet $wallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wallet $wallet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wallet $wallet)
    {
        //
    }
}
