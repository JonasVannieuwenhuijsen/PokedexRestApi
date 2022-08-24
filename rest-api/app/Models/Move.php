<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Move extends Model
{
    use HasFactory;


    public function version_group_details()
    {
        return $this->hasMany(Version_group_detail::class);
    }


}
