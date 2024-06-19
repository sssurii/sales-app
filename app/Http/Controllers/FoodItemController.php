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
        if ($request->hasFile('image')) {
            $foodItem->image = $request->file('image')->store('food_items');
            $foodItem->save();
        }

        return redirect()->route('food_items.index')->with('success', $foodItem->name . ' created successfully!');
    }

    public function show(Request $request, FoodItem $foodItem): View
    {
        return view('food_items.show', compact('foodItem'));
    }

    public function update(FoodItemUpdateRequest $request, FoodItem $foodItem): RedirectResponse
    {
        $foodItem->update($request->validated());
        if ($request->hasFile('image')) {
            $foodItem->image = $request->file('image')->store('food_items');
            $foodItem->save();
        }
        return redirect()->route('foodItem.index')->with('success', $foodItem->name . ' updated successfully!');
    }

    public function destroy(Request $request, FoodItem $foodItem): RedirectResponse
    {
        $foodItems = FoodItem::find(id)->get();

        $foodItem->delete();

        $request->session()->flash(foodItem.name + ' deleted successfully!', $foodItem->name + ' deleted successfully!');

        return redirect()->route('food_items.index');
    }
}
