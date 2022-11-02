<?php

namespace AjCastro\EagerLoadPivotRelations\Tests\Models;

use AjCastro\EagerLoadPivotRelations\Tests\Database\Factories\CarUserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $id
 * @property int $car_id
 * @property int $color_id
 * @property int $user_id
 * @property-read \AjCastro\EagerLoadPivotRelations\Tests\Models\Car|null $car
 * @property-read \AjCastro\EagerLoadPivotRelations\Tests\Models\Color|null $color
 * @property-read \AjCastro\EagerLoadPivotRelations\Tests\Models\User|null $user
 * @method static \AjCastro\EagerLoadPivotRelations\Tests\Database\Factories\CarUserFactory factory(...$parameters)
 * @method static Builder|CarUser newModelQuery()
 * @method static Builder|CarUser newQuery()
 * @method static Builder|CarUser query()
 * @mixin \Eloquent
 */
class CarUser extends Pivot
{
    use HasFactory;

    public $incrementing = true;
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
