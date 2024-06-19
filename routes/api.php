<?php

use App\Http\Controllers\FoodItemController;
use App\Http\Controllers\OrderController;
use App\Models\FoodItem;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware([])->group(function (){
    Route::get('/users', function () {
        return User::all();
    });
    Route::get('/orders', function () {
        return Order::with(['user'])->orderBy('updated_at')->get()->all();
    });

    Route::get('/orders/{orderId}', function ( int $orderId) {
        return Order::with(['user', 'orderItems'])->find($orderId);
    });

    Route::post('/orders', OrderController::class . '@store');

    Route::put('/orders/{orderId}', function (Request $request, int $orderId) {
        $order = Order::find($orderId);
        $order->fill($request->all());
        $order->save();
        return $order;
    });

    Route::delete('/orders/{orderId}', function ( int $orderId) {
        $order = Order::find($orderId);
        $order->delete();
        return $order;
    });

    Route::get('/food-items', function () {
        return FoodItem::all();
    })->name('food_items.index');

    Route::post('/food-items', FoodItemController::class . '@store');
    Route::post('/food-items/{foodItemId}', FoodItemController::class . '@update');
    Route::get('/food-items/{foodItemId}', function ( string|int $foodItemId) {
        return FoodItem::find($foodItemId);
    });
});
