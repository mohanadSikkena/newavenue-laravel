<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Licence;

class LicenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $licence=new Licence;
        $licence->name='Administrative';
        $licence->save();
        $licence=new Licence;
        $licence->name='Commercial';
        $licence->save();
        $licence=new Licence;
        $licence->name='Medical';
        $licence->save();
        $licence=new Licence;
        $licence->name='Hospital';
        $licence->save();
        $licence=new Licence;
        $licence->name='Garage';
        $licence->save();
        $licence=new Licence;
        $licence->name='Industrial';
        $licence->save();
        $licence=new Licence;
        $licence->name='Storage';
        $licence->save();


    }
}
