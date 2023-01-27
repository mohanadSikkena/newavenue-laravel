<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Property;

class Sub_category extends Model
{
    use HasFactory;

    public function properties(){
        return $this->hasMany(Property::class);       
    }
}
