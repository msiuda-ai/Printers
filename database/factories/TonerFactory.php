<?php

namespace Database\Factories;

use App\Models\Toner;
use App\Models\Printer;
use Illuminate\Database\Eloquent\Factories\Factory;

class TonerFactory extends Factory
{
    protected $model = Toner::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'color' => $this->faker->randomElement(['black', 'cyan', 'magenta', 'yellow']),
            'printer_id' => Printer::factory(),
            'level' => $this->faker->numberBetween(0, 100),
            'status' => $this->faker->randomElement(['ok', 'low', 'empty']),
        ];
    }
}

