<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MovieController;
use App\Http\Controllers\API\SeatSelectionController;
use App\Http\Controllers\API\OrderConfirmationController;
use App\Http\Controllers\API\TransactionHistoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function() {
    
    // Authentication API
    Route::POST('/login', [AuthController::class, 'login']);
    Route::GET('/logout', [AuthController::class, 'logout']);
    
    // Movie List
    Route::GET('/list-movie', [MovieController::class, 'listMovie']);
    
    // Seat Selection
    Route::GET('/seat-selection', [SeatSelectionController::class, 'seatSelection']);
    
    // Confirm Order
    Route::POST('/confirm-order', [OrderConfirmationController::class, 'orderConfirm']);
    
    // Transaction History
    Route::GET('/transaction-histories', [TransactionHistoryController::class, 'transactionHistory']);
});