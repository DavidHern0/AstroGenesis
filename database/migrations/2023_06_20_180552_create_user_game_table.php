<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserGameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_games', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->double('metal')->default(10000);
            $table->double('crystal')->default(10000);
            $table->double('deuterium')->default(0);
            $table->double('energy')->default(0);
            $table->double('metal_storage')->default(20000);
            $table->double('crystal_storage')->default(10000);
            $table->double('deuterium_storage')->default(10000);
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
        Schema::table('user_games', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });        
        Schema::dropIfExists('user_games');
    }
}