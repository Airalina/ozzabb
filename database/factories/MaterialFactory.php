<?php

namespace Database\Factories;

use App\Models\Material;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Material::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->randomNumber(5),
            'name' => $this->faker->word(),
            'family' => $this->faker->randomElement(['Conectores', 'Terminales', 'Cables', 'Sellos']),
            'color' => $this->faker->hexcolor(),
            'description' => $this->faker->text(),
            'line' => $this->faker->randomElement(['1', '2','3']),
            'usage' => $this->faker->randomElement(['1', '2','3']),
            'replace_id' => $this->faker->randomElement(['1', '2','3']),
            'stock_min' => $this->faker->randomNumber(2),
            'stock_max' => $this->faker->randomNumber(2),
            'stock' => $this->faker->randomNumber(2),
        ];
    }
}
