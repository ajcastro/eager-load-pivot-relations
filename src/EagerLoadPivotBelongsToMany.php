<?php

namespace AjCastro\EagerLoadPivotRelations;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class EagerLoadPivotBelongsToMany extends BelongsToMany
{
    /**
     * Execute the query as a "select" statement.
     *
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get($columns = ['*'])
    {
        // First we'll add the proper select columns onto the query so it is run with
        // the proper columns. Then, we will get the results and hydrate our pivot
        // models with the result of those columns as a separate model relation.
        $builder = $this->query->applyScopes();

        $columns = $builder->getQuery()->columns ? [] : $columns;

        $models = $builder->addSelect(
            $this->shouldSelect($columns)
        )->getModels();

        $this->hydratePivotRelation($models);

        // If we actually found models we will also eager load any relationships that
        // have been specified as needing to be eager loaded. This will solve the
        // n + 1 query problem for the developer and also increase performance.

        if (count($models) > 0) {
            $pivotEagerLoad = $this->getPivotEagerLoads($builder);

            if (! empty($pivotEagerLoad)) {
                $this->eagerLoadPivotRelations($models, $pivotEagerLoad);
            }

            $models = $builder->eagerLoadRelations($models);
        }

        return $this->related->newCollection($models);
    }

    /**
     * Get the pivot eager load relations.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return array
     */
    protected function getPivotEagerLoads($builder)
    {
        // Only return the eagerLoad `pivot.*` but not the `pivot`
        // because `pivot.*` contains the actual relations we want to eager load from the pivot model.
        $pivotEagerLoad = array_filter($builder->getEagerLoads(), function ($relation) {
            return Str::startsWith($relation, $this->accessor.'.');
        }, ARRAY_FILTER_USE_KEY);

        $builder->without(array_merge(
            [$this->accessor], // We make sure to also remove the `pivot` in the eagerLoad.
            array_keys($pivotEagerLoad)
        ));

        return $pivotEagerLoad;
    }

    /**
     * Eager load the relations of the pivot of the models.
     *
     * @return void
     */
    protected function eagerLoadPivotRelations(array $models, array $eagerLoad)
    {
        $pivots = Arr::pluck($models, $this->accessor);
        $eagerLoad = $this->removePivotFromEagerLoadKeys($eagerLoad);
        $builder = head($pivots)->query();
        $builder->with($eagerLoad)->eagerLoadRelations($pivots);
    }

    /**
     * Remove the `pivot.` part of the eager load relations
     * to get the actual relations of the pivot model.
     *
     * @return array
     */
    protected function removePivotFromEagerLoadKeys(array $eagerLoad)
    {
        $newEagerLoad = [];
        foreach ($eagerLoad as $name => $callback) {
            $name = substr($name, strlen($this->accessor) + 1);
            $newEagerLoad[$name] = $callback;
        }

        return $newEagerLoad;
    }
}
