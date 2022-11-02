<?php

namespace AjCastro\EagerLoadPivotRelations\Tests\Unit;

use AjCastro\EagerLoadPivotRelations\Tests\Models\CarUser;
use AjCastro\EagerLoadPivotRelations\Tests\Models\Tire;
use AjCastro\EagerLoadPivotRelations\Tests\Models\User;
use AjCastro\EagerLoadPivotRelations\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CountTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_use_with_count_pivot_relations()
    {
        $this->markTestSkipped('This could be a new feature, see #6');

        $user = User::factory()->create();
        $pivots = CarUser::factory( [ 'user_id' => $user->id ] )->count( 2 )->create();
        $tires = rand(4, 8);

        foreach($pivots as $pivot) {
            Tire::factory(['car_user_id' => $pivot->id])
                ->count($tires)
                ->create();
        }

        $user = User::with( [
            'cars',
            'cars.pivot.color',
            'cars.pivot' => function($query) {
                return $query->withCount('tires');
            }
        ] )
            ->find( $user->id );

        $this->assertSame($tires, $user->cars[0]->pivot->tires_count);
    }

    public function test_it_can_use_load_count_pivot_relations()
    {
        $this->markTestSkipped('This could be a new feature, see #6');

        $user = User::factory()->create();
        $pivots = CarUser::factory( [ 'user_id' => $user->id ] )->count( 2 )->create();
        $tires = rand(4, 8);

        foreach($pivots as $pivot) {
            Tire::factory(['car_user_id' => $pivot->id])
                ->count($tires)
                ->create();
        }

        $user = User::find($user->id);
        $user->load([
            'cars',
            'cars.pivot.color',
            'cars.pivot' => function($query) {
                return $query->withCount('tires');
            }]);

        $this->assertSame($tires, $user->cars[0]->pivot->tires_count);
    }
}