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
        Schema::create('customer_properties', function (Blueprint $table) {
            $table->id();
            $table->string('location');
            $table->string('description');
            $table->string('name');
            $table->string('phone');
            $table->string('price');
            $table->foreignId('sell_type_id');
            $table->foreign('sell_type_id')->references('id')->on('sell_types')->onUpdate('CASCADE')->onDelete('RESTRICT');
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
        Schema::dropIfExists('customer_properties');
    }
};
