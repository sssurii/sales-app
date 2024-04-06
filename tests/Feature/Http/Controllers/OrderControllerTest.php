<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Order;
use App\Models\Unsigned;
use App\Models\User;
use Illuminate\Support\Carbon;
use function Pest\Faker\fake;
use function Pest\Laravel\assertModelMissing;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

test('index displays view', function (): void {
    $orders = Order::factory()->count(3)->create();

    $response = get(route('orders.index'));

    $response->assertOk();
    $response->assertViewIs('orders.index');
    $response->assertViewHas('orders');
});


test('store uses form request validation')
    ->assertActionUsesFormRequest(
        \App\Http\Controllers\OrderController::class,
        'store',
        \App\Http\Requests\OrderStoreRequest::class
    );

test('store saves and redirects', function (): void {
    $customer = Unsigned::factory()->create();
    $table = Unsigned::factory()->create();
    $status = fake()->word();
    $sub_total = fake()->randomFloat(/** decimal_attributes **/);
    $tax = fake()->randomFloat(/** decimal_attributes **/);
    $total_price = fake()->randomFloat(/** decimal_attributes **/);
    $payment_method = fake()->word();

    $response = post(route('orders.store'), [
        'customer_id' => $customer->id,
        'table_id' => $table->id,
        'status' => $status,
        'sub_total' => $sub_total,
        'tax' => $tax,
        'total_price' => $total_price,
        'payment_method' => $payment_method,
    ]);

    $orders = Order::query()
        ->where('customer_id', $customer->id)
        ->where('table_id', $table->id)
        ->where('status', $status)
        ->where('sub_total', $sub_total)
        ->where('tax', $tax)
        ->where('total_price', $total_price)
        ->where('payment_method', $payment_method)
        ->get();
    expect($orders)->toHaveCount(1);
    $order = $orders->first();

    $response->assertRedirect(route('orders.index'));
    $response->assertSessionHas('order.id + ' order created successfully!'', $order->id + ' order created successfully!');
});


test('show displays view', function (): void {
    $order = Order::factory()->create();
    $orders = Order::factory()->count(3)->create();

    $response = get(route('orders.show', $order));

    $response->assertOk();
    $response->assertViewIs('orders.show');
    $response->assertViewHas('order');
});


test('update uses form request validation')
    ->assertActionUsesFormRequest(
        \App\Http\Controllers\OrderController::class,
        'update',
        \App\Http\Requests\OrderUpdateRequest::class
    );

test('update saves and redirects', function (): void {
    $order = Order::factory()->create();
    $orders = Order::factory()->count(3)->create();
    $customer = Unsigned::factory()->create();
    $table = Unsigned::factory()->create();
    $status = fake()->word();
    $created_at = Carbon::parse(fake()->dateTime());
    $updated_at = Carbon::parse(fake()->dateTime());
    $placed_by = fake()->word();
    $served_by = fake()->word();
    $customer_notes = fake()->text();
    $internal_notes = fake()->text();
    $sub_total = fake()->randomFloat(/** decimal_attributes **/);
    $tax = fake()->randomFloat(/** decimal_attributes **/);
    $discount = fake()->randomFloat(/** decimal_attributes **/);
    $discount_type = fake()->word();
    $total_price = fake()->randomFloat(/** decimal_attributes **/);
    $payment_method = fake()->word();
    $payment_reference = fake()->word();
    $payment_received = fake()->boolean();
    $user = User::factory()->create();

    $response = put(route('orders.update', $order), [
        'customer_id' => $customer->id,
        'table_id' => $table->id,
        'status' => $status,
        'created_at' => $created_at->toDateTimeString(),
        'updated_at' => $updated_at->toDateTimeString(),
        'placed_by' => $placed_by,
        'served_by' => $served_by,
        'customer_notes' => $customer_notes,
        'internal_notes' => $internal_notes,
        'sub_total' => $sub_total,
        'tax' => $tax,
        'discount' => $discount,
        'discount_type' => $discount_type,
        'total_price' => $total_price,
        'payment_method' => $payment_method,
        'payment_reference' => $payment_reference,
        'payment_received' => $payment_received,
        'user_id' => $user->id,
    ]);

    $orders = Order::query()
        ->where('customer_id', $customer->id)
        ->where('table_id', $table->id)
        ->where('status', $status)
        ->where('created_at', $created_at)
        ->where('updated_at', $updated_at)
        ->where('placed_by', $placed_by)
        ->where('served_by', $served_by)
        ->where('customer_notes', $customer_notes)
        ->where('internal_notes', $internal_notes)
        ->where('sub_total', $sub_total)
        ->where('tax', $tax)
        ->where('discount', $discount)
        ->where('discount_type', $discount_type)
        ->where('total_price', $total_price)
        ->where('payment_method', $payment_method)
        ->where('payment_reference', $payment_reference)
        ->where('payment_received', $payment_received)
        ->where('user_id', $user->id)
        ->get();
    expect($orders)->toHaveCount(1);
    $order = $orders->first();

    $response->assertRedirect(route('orders.show', [$order]));
    $response->assertSessionHas('order.id + ' order updated successfully!'', $order->id + ' order updated successfully!');
});


test('destroy deletes and redirects', function (): void {
    $order = Order::factory()->create();
    $orders = Order::factory()->count(3)->create();

    $response = delete(route('orders.destroy', $order));

    $response->assertRedirect(route('orders.index'));
    $response->assertSessionHas('order.id + ' order deleted successfully!'', $order->id + ' order deleted successfully!');

    assertModelMissing($order);
});
