<?php

namespace App\Models;
use App\Models\Property;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public function favourite(){
     return $this->belongsToMany(Property::class)->with('images:id,property_id,image');
    }


}
