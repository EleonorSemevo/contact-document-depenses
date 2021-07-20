<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Emprunsespece;

class EmprunsespeceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Emprunsespece::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date(),
            'creancier' => $this->faker->word,
            'montant' => $this->faker->numberBetween(-10000, 10000),
            'motif' => $this->faker->word,
            'date_prevue' => $this->faker->date(),
            'date_reelle' => $this->faker->date(),
            'obervation' => $this->faker->word,
        ];
    }
}
