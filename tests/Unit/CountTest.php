<?php

namespace AjCastro\EagerLoadPivotRelations\Tests\Unit;

use AjCastro\EagerLoadPivotRelations\Tests\Models\CarUser;
use AjCastro\EagerLoadPivotRelations\Tests\Models\User;
use AjCastro\EagerLoadPivotRelations\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CountTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_use_count_pivot_relations()
    {
        try
        {
            $user = User::factory()->create();
            $pivots = CarUser::factory( [ 'user_id' => $user->id ] )->count( 2 )->create();
        }catch(\Exception $exception)
        {
            dd($exception);
            throw $exception;
        }

        $user = User::with( [
            'cars',
            'cars.pivot.color',
            'cars.pivot' => function($query) {
                return $query->withCount('tires');
            }
        ] )
            ->find( $user->id );

        $this->assertSame(count($pivots[0]->tires), $user->cars[0]->pivot->tires_count);
    }
}