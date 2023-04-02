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


}
