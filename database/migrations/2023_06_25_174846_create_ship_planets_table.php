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
        Schema::create('ship_planets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ship_id');
            $table->unsignedBigInteger('planet_id');
            $table->integer('quantity');
            $table->timestamps();
            $table->foreign('ship_id')->references('id')->on('ships')->cascadeOnDelete();
            $table->foreign('planet_id')->references('id')->on('planets')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ship_levels', function (Blueprint $table) {
            $table->dropForeign(['ship_id']);
            $table->dropForeign(['planet_id']);
        });
        Schema::dropIfExists('ship_levels');
    }
};
