<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/orders', function () {
        return Inertia::render('Order/OrderList',  [
            'orders' => \App\Models\Order::with(['user'])->orderBy('updated_at')->get()->all()
        ]);
    })->name('orders.list');

    Route::get('/orders/create', function () {
        return Inertia::render('Order/OrderCreate',  [  ]);
    })->name('orders.create');

    Route::get('/orders/{orderId}', function ( int $orderId) {
        return Inertia::render('Order/OrderDetails',  [
            'order' => \App\Models\Order::with(['user', 'orderItems'])->find($orderId)
        ]);
    })->name('orders.details');

    Route::get('/foodItem/create', function () {
        return Inertia::render('FoodItems/CreateFoodItem',  [  ]);
    })->name('foodItem.create');

    Route::get('/foodItem/list', function () {
        return Inertia::render('FoodItems/list',  [  ]);
    })->name('foodItem.list');
    Route::get('/foodItem/{foodItemId}/edit', function () {
        return Inertia::render('FoodItems/edit',  [  ]);
    })->name('foodItem.edit');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::resource('food-items', App\Http\Controllers\FoodItemController::class)->except('create', 'edit');


Route::resource('food-items', App\Http\Controllers\FoodItemController::class)->except('create', 'edit');


Route::resource('tables', App\Http\Controllers\TableController::class)->except('create', 'edit');


//Route::resource('orders', App\Http\Controllers\OrderController::class)->except('create', 'edit');
