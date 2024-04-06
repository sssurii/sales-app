<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Table;
use function Pest\Faker\fake;
use function Pest\Laravel\assertModelMissing;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

test('index displays view', function (): void {
    $tables = Table::factory()->count(3)->create();

    $response = get(route('tables.index'));

    $response->assertOk();
    $response->assertViewIs('tables.index');
    $response->assertViewHas('tables');
});


test('store uses form request validation')
    ->assertActionUsesFormRequest(
        \App\Http\Controllers\TableController::class,
        'store',
        \App\Http\Requests\TableStoreRequest::class
    );

test('store saves and redirects', function (): void {
    $table_number = fake()->word();
    $capacity = fake()->numberBetween(-10000, 10000);
    $status = fake()->word();

    $response = post(route('tables.store'), [
        'table_number' => $table_number,
        'capacity' => $capacity,
        'status' => $status,
    ]);

    $tables = Table::query()
        ->where('table_number', $table_number)
        ->where('capacity', $capacity)
        ->where('status', $status)
        ->get();
    expect($tables)->toHaveCount(1);
    $table = $tables->first();

    $response->assertRedirect(route('tables.index'));
    $response->assertSessionHas('table.table_number + ' table created successfully!'', $table->table_number + ' table created successfully!');
});


test('show displays view', function (): void {
    $table = Table::factory()->create();
    $tables = Table::factory()->count(3)->create();

    $response = get(route('tables.show', $table));

    $response->assertOk();
    $response->assertViewIs('tables.show');
    $response->assertViewHas('table');
});


test('update uses form request validation')
    ->assertActionUsesFormRequest(
        \App\Http\Controllers\TableController::class,
        'update',
        \App\Http\Requests\TableUpdateRequest::class
    );

test('update saves and redirects', function (): void {
    $table = Table::factory()->create();
    $tables = Table::factory()->count(3)->create();
    $table_number = fake()->word();
    $capacity = fake()->numberBetween(-10000, 10000);
    $status = fake()->word();
    $location = fake()->word();

    $response = put(route('tables.update', $table), [
        'table_number' => $table_number,
        'capacity' => $capacity,
        'status' => $status,
        'location' => $location,
    ]);

    $tables = Table::query()
        ->where('table_number', $table_number)
        ->where('capacity', $capacity)
        ->where('status', $status)
        ->where('location', $location)
        ->get();
    expect($tables)->toHaveCount(1);
    $table = $tables->first();

    $response->assertRedirect(route('tables.show', [$table]));
    $response->assertSessionHas('table.table_number + ' table updated successfully!'', $table->table_number + ' table updated successfully!');
});


test('destroy deletes and redirects', function (): void {
    $table = Table::factory()->create();
    $tables = Table::factory()->count(3)->create();

    $response = delete(route('tables.destroy', $table));

    $response->assertRedirect(route('tables.index'));
    $response->assertSessionHas('table.table_number + ' table deleted successfully!'', $table->table_number + ' table deleted successfully!');

    assertModelMissing($table);
});
