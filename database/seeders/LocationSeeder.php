<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $location=new Location;
        $location->name="Heliopolis";
        $location->save();
        $location=new Location;
        $location->name="New Cairo";
        $location->save();
        $location=new Location;
        $location->name="New Capital";
        $location->save();
        $location=new Location;
        $location->name="Shorouk";
        $location->save();
        $location=new Location;
        $location->name="Mostakbal";
        $location->save();
        $location=new Location;
        $location->name="Obour";
        $location->save();
        $location=new Location;
        $location->name="Zayed";
        $location->save();
        $location=new Location;
        $location->name="October";
        $location->save();

        //
    }
}
