<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Domaine;
use App\Models\Intrant;

class IntrantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Intrant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'piece' => $this->faker->word,
            'domaine_id' => Domaine::factory(),
            'localite' => $this->faker->word,
            'date' => $this->faker->date(),
            'montant' => $this->faker->randomNumber(),
        ];
    }
}
