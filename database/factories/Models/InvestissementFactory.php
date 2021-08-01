<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Domaine;
use App\Models\Investissement;

class InvestissementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Investissement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'domaine_id' => Domaine::factory(),
            'date' => $this->faker->date(),
            'numero_piece' => $this->faker->numberBetween(-10000, 10000),
            'localite' => $this->faker->word,
            'cout_intrant' => $this->faker->numberBetween(-10000, 10000),
            'cout_main_oeuvre' => $this->faker->numberBetween(-10000, 10000),
            'cout_transport' => $this->faker->numberBetween(-10000, 10000),
            'prestataire' => $this->faker->word,
            'mail' => $this->faker->word,
            'telephone' => $this->faker->numberBetween(-10000, 10000),
        ];
    }
}
