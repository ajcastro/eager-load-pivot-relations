<?php

namespace AjCastro\EagerLoadPivotRelations;

use Closure;

class EagerLoadPivotBuilder extends \Illuminate\Database\Eloquent\Builder
{
    /**
     * Override.
     * Eagerly load the relationship on a set of models.
     *
     * @param  array  $models
     * @param  string  $name
     * @param  \Closure  $constraints
     * @return array
     */
    protected function eagerLoadRelation(array $models, $name, Closure $constraints)
    {
        if ($name === 'pivot') {
            $this->eagerLoadPivotRelations($models);
            return $models;
        }

        return parent::eagerLoadRelation($models, $name, $constraints);
    }

    /**
     * Eager load pivot relations.
     *
     * @param  array $models
     * @return void
     */
    protected function eagerLoadPivotRelations($models)
    {
        $pivots = array_pluck($models, 'pivot');
        $pivots = head($pivots)->newCollection($pivots);
        $pivots->load($this->getPivotEagerLoadRelations());
    }

    /**
     * Get the pivot relations to be eager loaded.
     *
     * @return array
     */
    protected function getPivotEagerLoadRelations()
    {
        $relations = array_filter(array_keys($this->eagerLoad), function ($relation) {
            return $relation != 'pivot' && str_contains($relation, 'pivot');
        });
        return array_map(function ($relation) {
            return substr($relation, strlen('pivot.'));
        }, $relations);
    }
}
