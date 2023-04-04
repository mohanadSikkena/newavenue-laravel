<?php

namespace App\Models;
use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    public function primary(){
        return $this->hasMany(PrimaryProperty::class)
        ->select(['id','name','delivery_date','min_total_price','min_space','max_space'])
        ->with('images:image,primary_property_id');
      }

}
