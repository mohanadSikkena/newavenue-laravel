<?php

namespace App\Models;
use App\Models\Primary_image;
use App\Models\Location;
use App\Models\PrimaryType;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrimaryProperty extends Model
{
    use HasFactory;

    public function images(){
        return $this->hasMany(Primary_image::class);
    }
    public function location(){
        return $this->belongsTo(Location::class);
    }
    public function primary_type(){
        return $this->belongsTo(PrimaryType::class);
    }


    public function similarProperties()
    {
        $properties = PrimaryProperty::with('images')
            ->where('id', '!=', $this->id)
            ->get();
        return $properties->sortByDesc(function ($property) {
            return $property->similarityScore($this);
        })->take(5)->values()->all();
    }


    public function similarityScore($property){
        $score=0;
        if ($property->primary_type_id === $this->primary_type_id) $score += 1;
        if ($property->location_id === $this->location_id) $score += 1;

    }


}
