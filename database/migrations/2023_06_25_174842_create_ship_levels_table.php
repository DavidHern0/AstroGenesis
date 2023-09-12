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
        Schema::create('ship_levels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ship_id');
            $table->integer('metal_cost');
            $table->integer('crystal_cost');
            $table->integer('deuterium_cost');
            $table->double('construction_time');
            $table->integer('cargo_capacity');
            $table->foreign('ship_id')->references('id')->on('ships')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ship_levels', function (Blueprint $table) {
            $table->dropForeign(['ship_id']);
        });
        Schema::dropIfExists('ship_levels');
    }
};
