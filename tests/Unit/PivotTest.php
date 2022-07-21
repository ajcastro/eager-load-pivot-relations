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

    public function test_it_can_with_pivot_relations()
    {
        $user = User::factory()->create();
        $pivots = CarUser::factory(['user_id' => $user->id])->count( 2 )->create();

        $user = User::with([
            'cars',
            'cars.pivot.color'
        ])
        ->find($user->id);

        $this->assertInstanceOf(Car::class, $user->cars[0]);
        $this->assertInstanceOf(Color::class, $user->cars[0]->pivot->color);
    }
}