<?php

namespace Database\Factories\PhpTop;

use Domain\PhpTop\Models\Fact;
use Illuminate\Database\Eloquent\Factories\Factory;



class FactFactory extends Factory
{
    protected $model = Fact::class;

    public function definition(): array
    {
        return [
            'title' => fake()->title(),
            'text' => fake()->text(),
        ];
    }
}
