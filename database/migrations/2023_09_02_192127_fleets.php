<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fleets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->timestamp('departure')->useCurrent();
            $table->timestamp('arrival');
            $table->string('shipsSent');
            $table->integer('success')->default(100);
            $table->integer('solar_system_position_arrival')->nullable();
            $table->integer('galaxy_position_arrival')->nullable();
            $table->integer('solar_system_position_departure');
            $table->integer('galaxy_position_departure');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fleets', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('fleets');
    }
};
