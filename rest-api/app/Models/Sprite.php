<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sprite extends Model
{
    use HasFactory;

    protected $table = 'sprites';

    protected $fillable = [
        'front_default',
        'front_female',
        'front_shiny',
        'front_shiny_female',
        'back_default',
        'back_female',
        'back_shiny',
        'back_shiny_female'
    ];
}
