<?php

namespace AjCastro\EagerLoadPivotRelations\Tests\Database\Factories;

use AjCastro\EagerLoadPivotRelations\Tests\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{
    protected $model = Car::class;

    public function definition()
    {
        return [
            'make' => $this->faker->word,
            'model' => $this->faker->word,
        ];
    }
}
