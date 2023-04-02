<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PrimaryType;

class PrimaryTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $location=new PrimaryType;
        $location->name="Mixed Use";
        $location->save();
        $location=new PrimaryType;
        $location->name="Commercial Strip";
        $location->save();
        $location=new PrimaryType;
        $location->name="Mall";
        $location->save();
        $location=new PrimaryType;
        $location->name="Office";
        $location->save();

        //
    }
}
