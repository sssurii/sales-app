<?php

namespace App\Http\Controllers;

use App\Http\Requests\FoodItemStoreRequest;
use App\Http\Requests\FoodItemUpdateRequest;
use App\Models\FoodItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FoodItemController extends Controller
{
    public function index(Request $request): View
    {
        $foodItems = FoodItem::all();

        return view('food_items.index', compact('foodItems'));
    }

    public function store(FoodItemStoreRequest $request): RedirectResponse
    {
        $foodItem = FoodItem::create($request->validated());

        $request->session()->flash(foodItem.name + ' created successfully!', $foodItem->name + ' created successfully!');

        return redirect()->route('food_items.index');
    }

    public function show(Request $request, FoodItem $foodItem): View
    {
        $foodItems = FoodItem::find(id)->get();

        return view('food_items.show', compact('foodItem'));
    }

    public function update(FoodItemUpdateRequest $request, FoodItem $foodItem): RedirectResponse
    {
        $foodItems = FoodItem::find(id)->get();


        $foodItem->save();

        $request->session()->flash(foodItem.name + ' updated successfully!', $foodItem->name + ' updated successfully!');

        return redirect()->route('food_items.show', [$foodItem]);
    }

    public function destroy(Request $request, FoodItem $foodItem): RedirectResponse
    {
        $foodItems = FoodItem::find(id)->get();

        $foodItem->delete();

        $request->session()->flash(foodItem.name + ' deleted successfully!', $foodItem->name + ' deleted successfully!');

        return redirect()->route('food_items.index');
    }
}
