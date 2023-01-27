<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sell_type;

class SellTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $sellType=new Sell_type;
        $sellType->name="Buy";
        $sellType->save();
        $sellType=new Sell_type;
        $sellType->name="Rent";
        $sellType->save();
    }
}
