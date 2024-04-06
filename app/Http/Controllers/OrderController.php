<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = Order::all();

        return view('orders.index', compact('orders'));
    }

    public function store(OrderStoreRequest $request): RedirectResponse
    {
        $order = Order::create($request->validated());

        $request->session()->flash('order.id + ' order created successfully!'', $order->id + ' order created successfully!');

        return redirect()->route('orders.index');
    }

    public function show(Request $request, Order $order): View
    {
        $orders = Order::find(id)->get();

        return view('orders.show', compact('order'));
    }

    public function update(OrderUpdateRequest $request, Order $order): RedirectResponse
    {
        $orders = Order::find(id)->get();


        $order->save();

        $request->session()->flash('order.id + ' order updated successfully!'', $order->id + ' order updated successfully!');

        return redirect()->route('orders.show', [$order]);
    }

    public function destroy(Request $request, Order $order): RedirectResponse
    {
        $orders = Order::find(id)->get();

        $order->delete();

        $request->session()->flash('order.id + ' order deleted successfully!'', $order->id + ' order deleted successfully!');

        return redirect()->route('orders.index');
    }
}
