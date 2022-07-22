<?php

namespace AjCastro\EagerLoadPivotRelations\Tests\Database\Factories;

use AjCastro\EagerLoadPivotRelations\Tests\Models\CarUser;
use AjCastro\EagerLoadPivotRelations\Tests\Models\Tire;
use Illuminate\Database\Eloquent\Factories\Factory;

class TireFactory extends Factory
{
    protected $model = Tire::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'profile_depth' => $this->faker->randomNumber(2),
            'car_user_id' => function()
            {
                return CarUser::factory()->create()->id;
            }
        ];
    }
}
