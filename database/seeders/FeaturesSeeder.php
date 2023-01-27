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
        $feature->name="Balcony";
        $feature->save();
        $feature=new Feature;
        $feature->name="Cable-Ready";
        $feature->save();
        $feature=new Feature;
        $feature->name="Centeral Air Conditioning";
        $feature->save();
        $feature=new Feature;
        $feature->name="Conference Room";
        $feature->save();
        $feature=new Feature;
        $feature->name="Covered parking";
        $feature->save();
        $feature=new Feature;
        $feature->name="Pantry";
        $feature->save();
        $feature=new Feature;
        $feature->name="Private Garden";
        $feature->save();
        $feature=new Feature;
        $feature->name="Security";
        $feature->save();
        $feature=new Feature;
        $feature->name="Shared GYM";
        $feature->save();
    }
}
