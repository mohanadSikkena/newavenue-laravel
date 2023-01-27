<?php

namespace Database\Seeders;
use App\Models\Sub_category;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $subCategory=new Sub_category();
        $subCategory->name="show rooms";
        $subCategory->save();
        $subCategory=new Sub_category();
        $subCategory->name="retails";
        $subCategory->save();
        $subCategory=new Sub_category();
        $subCategory->name="food and bavrege";
        $subCategory->save();
        $subCategory=new Sub_category();
        $subCategory->name="malls";
        $subCategory->save();
        $subCategory=new Sub_category();
        $subCategory->name="offices";
        $subCategory->save();
        $subCategory=new Sub_category();
        $subCategory->name="buildings";
        $subCategory->save();
        $subCategory=new Sub_category();
        $subCategory->name="co-work space";
        $subCategory->save();
        $subCategory=new Sub_category();
        $subCategory->name="factories";
        $subCategory->save();
        $subCategory=new Sub_category();
        $subCategory->name="warehouses";
        $subCategory->save();
        $subCategory=new Sub_category();
        $subCategory->name="car service stations";
        $subCategory->save();
        $subCategory=new Sub_category();
        $subCategory->name="clinic";
        $subCategory->save();
        $subCategory=new Sub_category();
        $subCategory->name="hospital";
        $subCategory->save();
        $subCategory=new Sub_category();
        $subCategory->name="income property";
        $subCategory->save();

    }
}
