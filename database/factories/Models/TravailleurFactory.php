<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Domaine;
use App\Models\Travailleur;

class TravailleurFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Travailleur::class;

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
            'prestataire' => $this->faker->word,
            'mail' => $this->faker->word,
            'telephone' => $this->faker->word,
        ];
    }
}
