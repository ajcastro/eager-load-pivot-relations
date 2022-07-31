<?php

namespace AjCastro\EagerLoadPivotRelations\Tests\Database\Factories;

use AjCastro\EagerLoadPivotRelations\Tests\Models\CarUser;
use AjCastro\EagerLoadPivotRelations\Tests\Models\Tire;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\AjCastro\EagerLoadPivotRelations\Tests\Models\Tire>
 */
class TireFactory extends Factory
{
    protected $model = Tire::class;

    public function definition()
    {
        return [
            'brand' => $this->faker->word,
            'profile_depth' => $this->faker->randomNumber(2),
            'car_user_id' => function()
            {
                return CarUser::factory()->create()->id;
            }
        ];
    }
}