<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    use HasFactory;

    protected $table = 'stats';

    protected $fillable = [
        'stat',
        'base_stat',
        'effort'
    ];

    public function pokemon()
    {
        return $this->belongsTo(Pokemon::class);
    }
    
}
