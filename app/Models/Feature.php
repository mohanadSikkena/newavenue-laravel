<?php

namespace App\Models;
use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Feature extends Model
{
    use HasFactory;

    public function properties(){
        return $this->belongsToMany(Property::class);
    }
}
