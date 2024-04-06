<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\FoodItem;
use function Pest\Faker\fake;
use function Pest\Laravel\assertModelMissing;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

test('index displays view', function (): void {
    $foodItems = FoodItem::factory()->count(3)->create();

    $response = get(route('food-items.index'));

    $response->assertOk();
    $response->assertViewIs('food_items.index');
    $response->assertViewHas('foodItems');
});


test('store uses form request validation')
    ->assertActionUsesFormRequest(
        \App\Http\Controllers\FoodItemController::class,
        'store',
        \App\Http\Requests\FoodItemStoreRequest::class
    );

test('store saves and redirects', function (): void {
    $name = fake()->name();
    $description = fake()->text();
    $price = fake()->randomFloat(/** decimal_attributes **/);
    $category = fake()->word();
    $availability = fake()->boolean();
    $image = fake()->word();

    $response = post(route('food-items.store'), [
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'category' => $category,
        'availability' => $availability,
        'image' => $image,
    ]);

    $foodItems = FoodItem::query()
        ->where('name', $name)
        ->where('description', $description)
        ->where('price', $price)
        ->where('category', $category)
        ->where('availability', $availability)
        ->where('image', $image)
        ->get();
    expect($foodItems)->toHaveCount(1);
    $foodItem = $foodItems->first();

    $response->assertRedirect(route('food_items.index'));
    $response->assertSessionHas('foodItem.name + ' created successfully!'', $foodItem->name + ' created successfully!');
});


test('show displays view', function (): void {
    $foodItem = FoodItem::factory()->create();
    $foodItems = FoodItem::factory()->count(3)->create();

    $response = get(route('food-items.show', $foodItem));

    $response->assertOk();
    $response->assertViewIs('food_items.show');
    $response->assertViewHas('foodItem');
});


test('update uses form request validation')
    ->assertActionUsesFormRequest(
        \App\Http\Controllers\FoodItemController::class,
        'update',
        \App\Http\Requests\FoodItemUpdateRequest::class
    );

test('update saves and redirects', function (): void {
    $foodItem = FoodItem::factory()->create();
    $foodItems = FoodItem::factory()->count(3)->create();
    $name = fake()->name();
    $description = fake()->text();
    $price = fake()->randomFloat(/** decimal_attributes **/);
    $category = fake()->word();
    $availability = fake()->boolean();
    $image = fake()->word();

    $response = put(route('food-items.update', $foodItem), [
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'category' => $category,
        'availability' => $availability,
        'image' => $image,
    ]);

    $foodItems = FoodItem::query()
        ->where('name', $name)
        ->where('description', $description)
        ->where('price', $price)
        ->where('category', $category)
        ->where('availability', $availability)
        ->where('image', $image)
        ->get();
    expect($foodItems)->toHaveCount(1);
    $foodItem = $foodItems->first();

    $response->assertRedirect(route('food_items.show', [$foodItem]));
    $response->assertSessionHas('foodItem.name + ' updated successfully!'', $foodItem->name + ' updated successfully!');
});


test('destroy deletes and redirects', function (): void {
    $foodItem = FoodItem::factory()->create();
    $foodItems = FoodItem::factory()->count(3)->create();

    $response = delete(route('food-items.destroy', $foodItem));

    $response->assertRedirect(route('food_items.index'));
    $response->assertSessionHas('foodItem.name + ' deleted successfully!'', $foodItem->name + ' deleted successfully!');

    assertModelMissing($foodItem);
});
