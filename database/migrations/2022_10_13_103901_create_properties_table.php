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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('location');
            $table->string('price');
            $table->string('area');
            $table->bigInteger('views')->default(0);
            $table->string('description');
            $table->boolean('confirmed')->default(false);
            $table->foreignId('agent_id');
            $table->foreignId('sell_type_id');
            $table->foreignId('sub_category_id');
            $table->foreign('agent_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('sell_type_id')->references('id')->on('sell_types')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
};
