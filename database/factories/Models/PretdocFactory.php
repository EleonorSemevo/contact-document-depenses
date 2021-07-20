<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Document;
use App\Models\Pretdoc;

class PretdocFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pretdoc::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'document_id' => Document::factory(),
            'date_prevue' => $this->faker->date(),
            'date_reelle' => $this->faker->date(),
            'observation' => $this->faker->text,
        ];
    }
}
