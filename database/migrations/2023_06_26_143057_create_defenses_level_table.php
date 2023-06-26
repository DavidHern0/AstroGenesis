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
        Schema::create('defense_levels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('defense_id');
            $table->double('metal_cost');
            $table->double('crystal_cost');
            $table->double('deuterium_cost');
            $table->double('construction_time');
            $table->foreign('defense_id')->references('id')->on('defenses')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('defense_levels', function (Blueprint $table) {
            $table->dropForeign(['defense_id']);
        });
        Schema::dropIfExists('defense_levels');
    }
};
