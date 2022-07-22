<?php

namespace AjCastro\EagerLoadPivotRelations\Tests\Models;

use AjCastro\EagerLoadPivotRelations\Tests\Database\Factories\CarFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;

class Car extends Model
{
    use EagerLoadPivotTrait;
    use HasFactory;

    protected $table = 'cars';
    protected $fillable = [
        'model',
        'brand_id',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('color_id')
            ->using(CarUser::class)
            ->as('car_user');
    }

    protected static function newFactory()
    {
        return CarFactory::new();
    }
}
