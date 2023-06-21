<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingPlanetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_planets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('building_id');
            $table->unsignedBigInteger('planet_id');
            $table->integer('level');
            $table->foreign('building_id')->references('id')->on('buildings')->cascadeOnDelete();
            $table->foreign('planet_id')->references('id')->on('planets')->cascadeOnDelete();
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
        Schema::table('building_planets', function (Blueprint $table) {
            $table->dropForeign(['building_id']);
            $table->dropForeign(['planet_id']);
        });
        Schema::dropIfExists('building_users');
    }
}
