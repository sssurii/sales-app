<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Table;

class TableFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Table::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'table_number' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'capacity' => $this->faker->numberBetween(-10000, 10000),
            'status' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'location' => $this->faker->regexify('[A-Za-z0-9]{255}'),
        ];
    }
}
