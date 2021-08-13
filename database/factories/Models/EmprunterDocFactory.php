<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\EmprunterDoc;

class EmprunterDocFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmprunterDoc::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date(),
            'date_prevue' => $this->faker->date(),
            'date_reelle' => $this->faker->date(),
            'creancier' => $this->faker->word,
            'motif' => $this->faker->word,
            'observation' => $this->faker->text,
            'titre' => $this->faker->word,
            'sous_titre' => $this->faker->word,
            'auteur' => $this->faker->word,
            'co_auteur' => $this->faker->word,
            'ISBN' => $this->faker->numberBetween(-10000, 10000),
            'mots_cles' => $this->faker->text,
            'resume' => $this->faker->text,
            'annee_edition' => $this->faker->year(),
            'ville_edition' => $this->faker->word,
            'lieu_edition' => $this->faker->word,
            'nombre_page' => $this->faker->numberBetween(-10000, 10000),
            'pp' => $this->faker->word,
            'editeur' => $this->faker->word,
            'edition' => $this->faker->word,
        ];
    }
}
