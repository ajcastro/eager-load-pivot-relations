<?php

namespace AjCastro\EagerLoadPivotRelations\Tests\Models;

use AjCastro\EagerLoadPivotRelations\Tests\Database\Factories\TireFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $brand
 * @property int $profile_depth
 * @property int $car_user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \AjCastro\EagerLoadPivotRelations\Tests\Database\Factories\TireFactory factory(...$parameters)
 * @method static Builder|Tire newModelQuery()
 * @method static Builder|Tire newQuery()
 * @method static Builder|Tire query()
 * @mixin \Eloquent
 */
class Tire extends Model
{
    use HasFactory;

    protected $table = 'tires';
    protected $fillable = [
        'brand',
        'profile_depth',
        'car_user_id',
    ];

    protected static function newFactory()
    {
        return TireFactory::new();
    }
}
