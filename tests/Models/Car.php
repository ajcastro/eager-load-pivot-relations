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
        'make'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('color_id')
            ->using(CarUser::class);
    }

    protected static function newFactory()
    {
        return CarFactory::new();
    }
}
