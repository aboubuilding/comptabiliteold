<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Annee>
 */
class AnneeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [


              'libelle' => $this->faker->name(),
            'date_rentree' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'date_fin' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'date_ouverture_inscription' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'date_fermeture_reinscription' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'statut_annee' => $this->faker->randomElement([1, 2]),
           


            //
        ];
    }
}
