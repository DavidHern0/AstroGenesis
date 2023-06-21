<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServerLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // public function up()
    // {
    //     Schema::create('server_logs', function (Blueprint $table) {
    //         $table->id();
    //         $table->timestamp('timestamp')->default(\DB::raw('CURRENT_TIMESTAMP'));
    //         $table->enum('event_type', ['RESOURCE_COLLECT', 'BUILDING_UPGRADE']);
    //         $table->unsignedBigInteger('user_id');
    //         $table->unsignedBigInteger('planet_id')->nullable();
    //         $table->unsignedBigInteger('building_id')->nullable();
    //         $table->enum('resource_type', ['METAL', 'CRYSTAL', 'DEUTERIUM']);
    //         $table->integer('resource_amount');
    //         $table->text('description');
    //         $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
    //         $table->foreign('planet_id')->references('id')->on('planets')->cascadeOnDelete();
    //         $table->foreign('building_id')->references('id')->on('buildings')->cascadeOnDelete();
    //         $table->timestamps();
    //     });
    // }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    // public function down()
    // {
    //     Schema::table('server_logs', function (Blueprint $table) {
    //     $table->dropForeign(['user_id']);
    //     $table->dropForeign(['planet_id']);
    //     $table->dropForeign(['building_id']);
    //     });
    //     Schema::dropIfExists('server_logs');
    // }
}
