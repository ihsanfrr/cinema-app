<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionHistoryController extends Controller
{
    public function transactionHistory(Request $request){
        $user = User::where('remember_token', $request->token)->first();
        
        if (!empty($request->token) && $user) {
            $dataPurchase = Purchase::with('movie', 'seat', 'created_by')->get();
            return response()->json([
                'purchase' => $dataPurchase
            ], 200);
        } else {
            return response()->json([
                'message' => 'Unathorized user'
            ], 401);
        }
    }
}
