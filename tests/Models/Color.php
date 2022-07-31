<?php

namespace AjCastro\EagerLoadPivotRelations\Tests\Models;

use AjCastro\EagerLoadPivotRelations\Tests\Database\Factories\ColorFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \AjCastro\EagerLoadPivotRelations\Tests\Database\Factories\ColorFactory factory(...$parameters)
 * @method static Builder|Color newModelQuery()
 * @method static Builder|Color newQuery()
 * @method static Builder|Color query()
 * @mixin \Eloquent
 */
class Color extends Model
{
    use HasFactory;

    protected $table = 'colors';
    protected $fillable = [
        'name'
    ];

    public function cars()
    {
        return $this->belongsToMany(Car::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    protected static function newFactory()
    {
        return ColorFactory::new();
    }
}
