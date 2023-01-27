<?php

namespace App\Models;
use App\Models\Property;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property_image extends Model
{
    use HasFactory;

    public function property(){
        return $this->belongsTo(Property::class);
    }
}
