<?php

namespace AjCastro\EagerLoadPivotRelations;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

trait EagerLoadPivotTrait
{
    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param QueryBuilder $query
     * @return EloquentBuilder
     */
    public function newEloquentBuilder(QueryBuilder $query): EloquentBuilder
    {
        return new EagerLoadPivotBuilder($query);
    }
}
