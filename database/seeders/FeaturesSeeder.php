<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Feature;
class FeaturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $feature=new Feature;
        $feature->name="Terrace";
        $feature->save();
        $feature=new Feature;
        $feature->name="Air Conditioned";
        $feature->save();
        $feature=new Feature;
        $feature->name="Centeral Air Conditioning";
        $feature->save();
        $feature=new Feature;
        $feature->name="Conference Room";
        $feature->save();
        $feature=new Feature;
        $feature->name="Parking";
        $feature->save();
        $feature=new Feature;
        $feature->name="Shared Meeting Room";
        $feature->save();
        $feature=new Feature;
        $feature->name="Private Garden";
        $feature->save();
        $feature=new Feature;
        $feature->name="Security";
        $feature->save();
        $feature=new Feature;
        $feature->name="Security System";
        $feature->save();
        $feature=new Feature;
        $feature->name="Open Space";
        $feature->save();
        $feature=new Feature;
        $feature->name="Street Location";
        $feature->save();

        $feature=new Feature;
        $feature->name="Near Transportation";
        $feature->save();


        $feature=new Feature;
        $feature->name="Near Resturants";
        $feature->save();
    }
}
