<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mobil>
 */
class MobilFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'merek' => fake()->regexify('[A-Z]{5}[0-4]{3}'),
            'image' => 'images/mobil.webp',
            'model' => fake()->randomElements(['Suzuki', 'Daihatsu', 'Toyota'])[0],
            'nomor_plat' => fake()->regexify('[A-Z]{5}[0-4]{3}'),
            'tarif_sewa' => fake()->numberBetween(300000, 500000),
        ];
    }
}
