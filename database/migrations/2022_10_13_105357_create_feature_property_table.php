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
        Schema::create('feature_property', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feature_id');
            $table->foreign('feature_id')->references('id')->on('features')->onUpdate('CASCADE')->onDelete('RESTRICT');


            $table->foreignId('property_id');
            $table->foreign('property_id')->references('id')->on('properties')->onUpdate('CASCADE')->onDelete('CASCADE');
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
        Schema::dropIfExists('property_features');
    }
};
