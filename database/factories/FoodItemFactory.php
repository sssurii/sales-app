<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\FoodItem;

class FoodItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FoodItem::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'price' => $this->faker->randomFloat(2, 0, 999999.99),
            'category' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'availability' => $this->faker->boolean(),
            'image' => $this->faker->regexify('[A-Za-z0-9]{255}'),
        ];
    }
}
