<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Models\PurchaseTicket;
use App\Http\Controllers\Controller;

class OrderConfirmationController extends Controller
{
    public function orderConfirm(Request $request){
        $user = User::where('remember_token', $request->token)->first();
        
        if (!empty($request->token) && $user) {

            if ($request->cash < $request->total) {
                return response()->json([
                    'message' => 'Uang pembayaran kurang!'
                ], 301);
            }

            $purchase = Purchase::create([
                'movie_id' => $request->movie_id,
                'date' => date('Y-m-d'),
                'time' => $request->time,
                'total' => $request->total,
                'cash' => $request->cash,
                'created_by' => $user->id,
            ]);
            
            $seats = explode(',', $request->orders);

            foreach ($seats as $seat) {
                PurchaseTicket::create([
                    'purchase_id' => $purchase->id,
                    'seat' => $seat
                ]);
            }

            return response()->json([
                'kembalian' => ($request->cash - $request->total),
                'id' => $purchase->id,
                'message' => 'pesanan berhasil dibuat',

            ], 200);

        } else {
            return response()->json([
                'message' => 'Unathorized user'
            ], 401);
        }
    }
}
