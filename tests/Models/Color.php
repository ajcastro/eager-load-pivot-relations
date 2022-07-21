<?php

namespace AjCastro\EagerLoadPivotRelations\Tests\Models;

use AjCastro\EagerLoadPivotRelations\Tests\Database\Factories\ColorFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $table = 'colors';
    protected $fillable = [
        'name'
    ];

    protected static function newFactory()
    {
        return ColorFactory::new();
    }
}
