<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletApiController extends Controller
{
    public function index()
    {
        $wallets = Wallet::with("user")->get();

        return response()->json([
            "message" => "index wallet",
            "data" => $wallets
        ], 200);
    }

    public function topUp(Request $request)
    {
        $user = Auth::user()->id;

        $topup = Wallet::create([
            "users_id" => $user,
            "credit" => $request->credit,
            "status" => "process"
        ]);

        return response()->json([
            'message' => 'top up',
            'user' => $user,
            'topup' => $topup
        ], 200);
    }

    public function topUpSuccess($id)
    {
        $wallet = Wallet::find($id);

        $wallet->update([
            "status" => "selesai"
        ]);

        return response()->json([
            'message' => 'top up success',
            'data' => $wallet
        ], 200);
    }
}
