<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Version_group_detail extends Model
{
    use HasFactory;

    protected $table = 'version_group_details';

    protected $fillable = [
        'move_learn_method',
        'version_group',
        'level_learned_at'
    ];
}
