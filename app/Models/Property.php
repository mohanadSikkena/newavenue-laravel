<?php

namespace App\Models;
use App\Models\Property_image;
use App\Models\Property_detail;
use App\Models\Feature;
use App\Models\Sell_type;
use App\Models\Sub_category;
use App\Models\Customer;
use App\Models\Licence;
use App\Models\Finish;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Property extends Model
{
    use HasFactory;
    use SoftDeletes;




    public static function withCommonReleations(){
        return static::with(
        'images:image,property_id',
        'features:name',
        'agent:name,id,about,img,description',
        'details:name,details,property_id',
        'subCategory:name,id',
        'licence:name,id',
        'finish:name,id',
        'sellType:name,id'
    );
    }


    public function similarProperties()
    {
        $properties = Property::with('images')->where('id', '!=', $this->id)->where("confirmed",true)->get();

        return $properties->sortByDesc(function ($property) {
            return $property->similarityScore($this);
        })->take(5)->values()->all();
    }

    public function similarityScore($property)
    {
        $score = 0;
        // Compare agent
        if ($property->agent_id === $this->agent_id) $score += 1;
        // Compare sell type
        if ($property->sell_type_id === $this->sell_type_id) $score += 1;
        // Compare sub-category
        if ($property->sub_category_id === $this->sub_category_id) $score += 1;
        // Compare licence
        if ($property->licence_id === $this->licence_id) $score += 1;
        // Compare finish
        if ($property->finish_id === $this->finish_id) $score += 1;
//        echo $score;
        return $score;
    }



    public function favourite(){
        return $this->belongsToMany(Customer::class);
    }

    public function details(){
        return $this->hasMany(Property_detail::class);
    }

    public function images(){
        return $this->hasMany(Property_image::class);
    }

    public function features(){
        return $this->belongsToMany(Feature::class,);
    }

    public function agent(){
        return $this->belongsTo(User::class);
    }

    public function sellType(){
        return $this->belongsTo(Sell_type::class);
    }
    public function subCategory(){
        return $this->belongsTo(Sub_category::class);
    }
    public function licence(){
        return $this->belongsTo(Licence::class);
    }
    public function finish(){
        return $this->belongsTo(Finish::class);
    }
}
