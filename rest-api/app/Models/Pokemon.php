<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    use HasFactory;

    protected $table = 'pokemon';

    protected $fillable = [
        'id',
        'name',
        'height',
        'weight',
        'order',
        'species',
        'form'
    ];

    public function abilities()
    {
        return $this->hasMany(Ability::class);
    }

    public function sprites()
    {
        return $this->hasOne(Sprite::class);
    }

    public function types()
    {
        return $this->hasMany(Type::class);
    }

    public function moves()
    {
        return $this->hasMany(Move::class);
    }

    public function stats()
    {
        return $this->hasMany(Stat::class);
    }

}
