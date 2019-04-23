# Laravel Eloquent: Eager Load Pivot Relations

Eager load pivot relations for Laravel Eloquent's BelongsToMany relation.  
Medium Story: https://medium.com/@ajcastro29/laravel-eloquent-eager-load-pivot-relations-dba579f3fd3a

## Installation

```
composer require ajcastro/eager-load-pivot-relations
```

## Usage and Example

There are use-cases where in a pivot model has relations to be eager loaded.
Example, in a procurement system, we have the following:

**Tables**

```
items
 - id
 - name

units
 - id
 - name (pc, box, etc...)

plans (annual procurement plan)
 - id

plan_item (pivot for plans and items)
 - id
 - plan_id
 - item_id
 - unit_id
```

**Models**

```php

class Unit extends \Eloquent {
    protected $fillable = [];
}

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
class Item extends \Eloquent
{
    // Use the trait here to override eloquent builder.
    // It is used in this model because it is the relation model defined in
    // Plan::items() relation.
    use EagerLoadPivotTrait;

    protected $fillable = [];

    public function plans()
    {
        return $this->belongsToMany('Plan', 'plan_item');
    }
}

class Plan extends \Eloquent
{
    protected $fillable = [];

    public function items()
    {
        return $this->belongsToMany('Item', 'plan_item')
            ->using('PlanItem')
            // make sure to include the necessary foreign key in this case the `unit_id`
            ->withPivot('unit_id', 'qty', 'price');
    }
}


// Pivot model
class PlanItem extends \Illuminate\Database\Eloquent\Relations\Pivot
{
    protected $table = 'plan_item';

    public function unit()
    {
        return $this->belongsTo('Unit');
    }
}
```

From the code above, `plans` and `items` has `Many-to-Many` relationship. Each item in a plan has a selected `unit`, unit of measurement.
It also possible for other scenario that the pivot model will have other many relations.

## Eager Loading Pivot Relations

Use keyword `pivot` in eager loading pivot models. So from the example above, the pivot model `PlanItem` can eager load the `unit` relation by doing this:

```
return Plan::with('items.pivot.unit')->get();
```

The resulting data structure will be:

![image](https://cloud.githubusercontent.com/assets/4918318/17958278/0d3c962a-6acb-11e6-8415-c48d01457cd6.png)

You may also access other relations for example:

```
return Plan::with([
  'items.pivot.unit',
  'items.pivot.unit.someRelation',
  'items.pivot.anotherRelation',
  // It is also possible to eager load nested pivot models
  'items.pivot.unit.someBelongsToManyRelation.pivot.anotherRelationFromAnotherPivot',
])->get();
```

## TODO/Need Help:

I would like to support customising the `pivot` keyword.
If you chain the `as()` method to define the __"pivot accessor"__ of the `BelongsToMany` relation,
it should use the defined pivot accessor.

```php
class Plan extends \Eloquent
{
    protected $fillable = [];

    public function items()
    {
        return $this->belongsToMany('Item', 'plan_item')
            ->withPivot('unit_id', 'qty', 'price')
            ->using('PlanItem')
            ->as('planItem');
    }
}

```
So instead of using `pivot`, we can eager load it by defined pivot accessor `planItem`.

```
return Plan::with('items.planItem.unit')->get();
```
