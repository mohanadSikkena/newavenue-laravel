<?php

namespace App\Models;
use App\Models\Property_image;
use App\Models\Property_detail;
use App\Models\Feature;
use App\Models\Sell_type;
use App\Models\Category;
use App\Models\Sub_category;
use App\Models\Customer;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Property extends Model
{
    use HasFactory;
    use SoftDeletes;



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

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function subCategory(){
        return $this->belongsTo(Sub_category::class);
    }
}
