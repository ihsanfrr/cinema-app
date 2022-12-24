<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Movie;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SeatSelectionController extends Controller
{
    public function seatSelection(Request $request) {
        $user = User::where('remember_token', $request->token)->first();
        
        if (!empty($request->token) && $user) {
            if (empty($request->id) && empty($request->time)) {
                return response()->json([
                    'message' => 'masukkan id film'
                ], 400);
            }

            $movie = Movie::find($request->id);

            $purchases = Purchase::where([['movie_id', '=', $movie->id], ['time', '=',$request->time]])->with('seat')->get();           
            
            $purchaseSeatSolds = [];
            
            if ($purchases != null) {
                foreach($purchases as $purchase) {
                    foreach($purchase->seat as $seat) {
                        $purchaseSeatSolds[] = $seat->seat;
                    }
                }
            }
        
            return response()->json([
                'date' => date('d F'),
                'time_choose' => $request->time,
                'id' => $movie->id,
                'movie_name' => $movie->name,
                'studio_name' => $movie->studio_name,
                'studio_capacity' => $movie->studio_capacity,
                'seats_sold' => $purchaseSeatSolds != null ? $purchaseSeatSolds : null
            ], 200);
        } else {
            return response()->json([
                'message' => 'Unauthorized user'
            ], 401);
        }
    }
}