<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_levels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('building_planet_id');
            $table->integer('level');
            $table->integer('metal_cost');
            $table->integer('crystal_cost');
            $table->integer('deuterium_cost');
            $table->integer('energy_cost');
            $table->integer('production_rate');
            $table->string('resource_type')->nullable();
            $table->foreign('building_id')->references('id')->on('buildings')->cascadeOnDelete();
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
        Schema::table('building_levels', function (Blueprint $table) {
            $table->dropForeign(['building_id']);
        });
        Schema::dropIfExists('building_levels');
    }
}
