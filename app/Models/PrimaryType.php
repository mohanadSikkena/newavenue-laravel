<?php

namespace App\Models;
use App\Models\Property;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrimaryType extends Model
{
    use HasFactory;


    public function primary(){
        return $this->hasMany(PrimaryProperty::class);
    }
}
