<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name')->default('PRINCIPAL PLANET');
            $table->enum('type', ['planet', 'moon']);
            $table->enum('biome', ['desert', 'dry', 'gas', 'ice', 'savanna', 'jungle', 'water']);
            $table->integer('variation');
            $table->integer('solar_system_position');
            $table->integer('galaxy_position');
            $table->string('info');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
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
        Schema::table('planets', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('planets');
    }
}
