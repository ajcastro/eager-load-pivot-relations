<?php

namespace AjCastro\EagerLoadPivotRelations\Tests\Models;

use AjCastro\EagerLoadPivotRelations\Tests\Database\Factories\TireFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tire extends Model
{
    use HasFactory;

    protected $table = 'tires';
    protected $fillable = [
        'name',
        'profile_depth',
        'car_user_id',
    ];

    public function car_user()
    {
        return $this->belongsTo(CarUser::class);
    }

    protected static function newFactory()
    {
        return TireFactory::new();
    }
}