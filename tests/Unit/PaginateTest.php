<?php

namespace AjCastro\EagerLoadPivotRelations\Tests\Unit;

use AjCastro\EagerLoadPivotRelations\Tests\Models\Car;
use AjCastro\EagerLoadPivotRelations\Tests\Models\CarUser;
use AjCastro\EagerLoadPivotRelations\Tests\Models\User;
use AjCastro\EagerLoadPivotRelations\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginateTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_paginate_with_pivot_relations()
    {
        $pivots = CarUser::factory()->count( 30 )->create();

        $users = User::with([
            'cars',
            'cars.pivot.color'
        ])
            ->paginate(10);

        $this->assertInstanceOf(LengthAwarePaginator::class, $users);
    }

    public function test_it_can_paginate_after_eager_loading_pivot_relations()
    {
        $this->markTestSkipped('Failing see #3');
        $pivots = CarUser::factory()->count( 30 )->create();

        $user = User::find(1)->cars()->with(['pivot.color'])->paginate(10);

        $this->assertInstanceOf(LengthAwarePaginator::class, $user);
    }

    public function test_it_can_paginate_with_custom_pivot_relations()
    {
        $pivots = CarUser::factory()->count( 30 )->create();

        $cars = Car::with([
            'users',
            'users.car_user.color'
        ])
            ->paginate(10);

        $this->assertInstanceOf(LengthAwarePaginator::class, $cars);
    }

    public function test_it_can_paginate_after_eager_loading_custom_pivot_relations()
    {
        $this->markTestSkipped('Failing see #3');
        $pivots = CarUser::factory()->count( 30 )->create();

        $car = Car::find(1)->users()->with(['car_user.color'])->paginate(10);

        $this->assertInstanceOf(LengthAwarePaginator::class, $car);
    }
}