<?php

namespace AjCastro\EagerLoadPivotRelations\Tests\Models;

use AjCastro\EagerLoadPivotRelations\Tests\Database\Factories\CarUserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CarUser extends Pivot
{
    use HasFactory;

    protected $table = 'car_user';
    protected $fillable =  [
        'car_id',
        'color_id',
        'user_id'
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function tires()
    {
        return $this->hasMany(Tire::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory()
    {
        return CarUserFactory::new();
    }
}
