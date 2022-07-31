<?php

namespace AjCastro\EagerLoadPivotRelations\Tests\Database\Factories;

use AjCastro\EagerLoadPivotRelations\Tests\Models\Brand;
use AjCastro\EagerLoadPivotRelations\Tests\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\AjCastro\EagerLoadPivotRelations\Tests\Models\Car>
 */
class CarFactory extends Factory
{
    protected $model = Car::class;

    public function definition()
    {
        return [
            'model' => $this->faker->words(rand(2, 4), true),
            'brand_id' => function()
            {
                return Brand::factory()->create()->id;
            }
        ];
    }
}
