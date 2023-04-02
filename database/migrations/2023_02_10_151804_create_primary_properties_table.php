<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('primary_properties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('delivery_date');
            $table->string('down_payment');
            $table->string('min_space');
            $table->string('max_space');


            $table->string('min_price');
            $table->string('max_price');
            $table->string('min_total_price');
            $table->string('min_Installment');
            $table->string('Maintnance');



            $table->foreignId('location_id');
            $table->foreign('location_id')->references('id')->on('locations')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('primary_properties');
    }
};
