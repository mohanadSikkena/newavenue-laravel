<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Property;

class Sub_category extends Model
{
    use HasFactory;

    public function properties(){
        return $this->hasMany(Property::class)->with(
            'images:image,property_id',
            'features:name',
            'agent:name,id,about,img,description',
            'details:name,details,property_id',
            'subCategory:name,id',
            'licence:name,id',
            'finish:name,id',
            'sellType:name,id'
        )
        ->where('confirmed',true);
    }
}
