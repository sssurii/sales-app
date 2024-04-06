<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\User;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'table_id' => $this->faker->numberBetween(-10000, 10000),
            'status' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
            'placed_by' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'served_by' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'customer_notes' => $this->faker->text(),
            'internal_notes' => $this->faker->text(),
            'sub_total' => $this->faker->randomFloat(2, 0, 999999.99),
            'tax' => $this->faker->randomFloat(2, 0, 999999.99),
            'discount' => $this->faker->randomFloat(2, 0, 999999.99),
            'discount_type' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'total_price' => $this->faker->randomFloat(2, 0, 999999.99),
            'payment_method' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'payment_reference' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'payment_received' => $this->faker->boolean(),
        ];
    }
}
