<?php

namespace AjCastro\EagerLoadPivotRelations\Tests\Unit;

use AjCastro\EagerLoadPivotRelations\Tests\Models\Car;
use AjCastro\EagerLoadPivotRelations\Tests\Models\CarUser;
use AjCastro\EagerLoadPivotRelations\Tests\Models\Color;
use AjCastro\EagerLoadPivotRelations\Tests\Models\User;
use AjCastro\EagerLoadPivotRelations\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PivotTest extends TestCase
{
    use RefreshDatabase;

    public function testItCanUseWithPivotRelations()
    {
        $user = User::factory()->create();
        $pivots = CarUser::factory(['user_id' => $user->id])->count(2)->create();

        $user = User::with([
            'cars',
            'cars.pivot.color',
        ])
            ->find($user->id);

        $this->assertInstanceOf(Car::class, $user->cars[0]);
        $this->assertInstanceOf(Color::class, $user->cars[0]->pivot->color);
    }

    public function testItCanUseLoadPivotRelations()
    {
        $user = User::factory()->create();
        $pivots = CarUser::factory(['user_id' => $user->id])->count(2)->create();

        $user->load([
            'cars',
            'cars.pivot.color',
        ]);

        $this->assertInstanceOf(Car::class, $user->cars[0]);
        $this->assertInstanceOf(Color::class, $user->cars[0]->pivot->color);
    }

    public function testItCanUseLoadMissingPivotRelations()
    {
        $user = User::factory()->create();
        $pivots = CarUser::factory(['user_id' => $user->id])->count(2)->create();

        $user->loadMissing([
            'cars',
            'cars.pivot.color',
        ]);

        $this->assertInstanceOf(Car::class, $user->cars[0]);
        $this->assertInstanceOf(Color::class, $user->cars[0]->pivot->color);
    }

    public function testItCanUseWithCustomPivotRelations()
    {
        $car = Car::factory()->create();
        $pivots = CarUser::factory(['car_id' => $car->id])->count(2)->create();

        $car = Car::with([
            'users',
            'users.car_user.color',
        ])
            ->find($car->id);

        $this->assertInstanceOf(User::class, $car->users[0]);
        $this->assertInstanceOf(Color::class, $car->users[0]->car_user->color);
    }

    public function testItCanUseLoadCustomPivotRelations()
    {
        $car = Car::factory()->create();
        $pivots = CarUser::factory(['car_id' => $car->id])->count(2)->create();

        $car->load([
            'users',
            'users.car_user.color',
        ]);

        $this->assertInstanceOf(User::class, $car->users[0]);
        $this->assertInstanceOf(Color::class, $car->users[0]->car_user->color);
    }

    public function testItCanUseLoadMissingCustomPivotRelations()
    {
        $car = Car::factory()->create();
        $pivots = CarUser::factory(['car_id' => $car->id])->count(2)->create();

        $car->loadMissing([
            'users',
            'users.car_user.color',
        ]);

        $this->assertInstanceOf(User::class, $car->users[0]);
        $this->assertInstanceOf(Color::class, $car->users[0]->car_user->color);
    }
}
