<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Finish;

class FinishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $finish=new Finish;
        $finish->name="Fully Finished";
        $finish->save();
        $finish=new Finish;
        $finish->name="Semi Finished";
        $finish->save();
        $finish=new Finish;
        $finish->name="Furnished";
        $finish->save();
        $finish=new Finish;
        $finish->name="Core And Shell";
        $finish->save();

    }
}
