<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'pokemon_1',
        'pokemon_2',
        'pokemon_3',
        'pokemon_4',
        'pokemon_5',
        'pokemon_6',
    ];
}
