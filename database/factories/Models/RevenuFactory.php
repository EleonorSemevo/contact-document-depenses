<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Revenu;
use App\Models\Typerevenu;

class RevenuFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Revenu::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'typerevenu_id' => Typerevenu::factory(),
            'montant' => $this->faker->numberBetween(-10000, 10000),
            'date' => $this->faker->date(),
        ];
    }
}
