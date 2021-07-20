<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Pretespece;

class PretespeceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pretespece::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date(),
            'debiteur' => $this->faker->word,
            'montant' => $this->faker->randomNumber(),
            'motif' => $this->faker->text,
            'date_prevue' => $this->faker->date(),
            'date_reelle' => $this->faker->date(),
            'obervation' => $this->faker->text,
        ];
    }
}
