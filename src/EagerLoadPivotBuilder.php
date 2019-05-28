<?php

namespace AjCastro\EagerLoadPivotRelations;

use Closure;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class EagerLoadPivotBuilder extends Builder
{
    protected static $knownPivotAccessors = [
        'pivot',
    ];

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
        $this->watchForPivotAccessors($name);

        if ($this->isPivotAccessor($name)) {
            $this->eagerLoadPivotRelations($models, $name);
            return $models;
        }

        return parent::eagerLoadRelation($models, $name, $constraints);
    }

    /**
     * Watch for pivot accessors to register it as known pivot accessors.
     *
     * @param  string $name
     * @return void
     */
    protected function watchForPivotAccessors($name)
    {
        $model = $this->getModel();

        if (!method_exists($model->newInstance(), $name)) {
            return;
        }

        $relation = $model->newInstance()->$name();

        if ($relation instanceof BelongsToMany) {
            static::$knownPivotAccessors[] = $relation->getPivotAccessor();
        }
    }

    /**
     * If relation name is a pivot accessor.
     *
     * @param  string  $name
     * @return boolean
     */
    protected function isPivotAccessor($name)
    {
        return in_array($name, static::$knownPivotAccessors);
    }

    /**
     * Eager load pivot relations.
     *
     * @param string $pivotAccessor
     * @param  array $models
     * @return void
     */
    protected function eagerLoadPivotRelations($models, $pivotAccessor)
    {
        $pivots = array_pluck($models, $pivotAccessor);
        $pivots = head($pivots)->newCollection($pivots);
        $pivots->load($this->getPivotEagerLoadRelations($pivotAccessor));
    }

    /**
     * Get the pivot relations to be eager loaded.
     *
     * @param string $pivotAccessor
     * @return array
     */
    protected function getPivotEagerLoadRelations($pivotAccessor)
    {
        $relations = array_filter($this->eagerLoad, function ($relation) use ($pivotAccessor) {
            return $relation != $pivotAccessor && str_contains($relation, $pivotAccessor);
        }, ARRAY_FILTER_USE_KEY);

        return array_combine(
            array_map(function ($relation) use ($pivotAccessor) {
                return substr($relation, strlen("{$pivotAccessor}."));
            }, array_keys($relations)),
            array_values($relations)
        );
    }
}
