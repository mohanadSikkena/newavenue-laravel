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
        Schema::table('primary_properties', function (Blueprint $table) {
            //
            $table->foreignId('primary_type_id')->index();
            $table->foreign('primary_type_id')->references('id')->on('primary_types')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('primary_properties', function (Blueprint $table) {
            //
        });
    }
};
