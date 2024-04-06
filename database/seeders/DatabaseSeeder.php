<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\FoodItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Table;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        //seed orders with order items, food items, tables, and users
        Table::factory(5)->create()->each(function ($table) {
            // Create 3 orders for each table, associating users and items
            $table->orders()->saveMany(
                Order::factory(3)->create()->each(function ($order) {
                    $order->user()->associate(User::factory()->create());  // Create and associate a user
                    $order->orderItems()->saveMany(
                        OrderItem::factory(3)->create()->each(function ($orderItem) {
                            $orderItem->foodItem()->associate(FoodItem::factory()->create());  // Create and associate a food item
                        })
                    );
                })
            );
        });
    }
}
