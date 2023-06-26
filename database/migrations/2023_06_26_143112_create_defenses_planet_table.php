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
        Schema::create('defense_planets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('defense_id');
            $table->unsignedBigInteger('planet_id');
            $table->integer('quantity')->default(0);
            $table->foreign('defense_id')->references('id')->on('defenses')->cascadeOnDelete();
            $table->foreign('planet_id')->references('id')->on('planets')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('defense_planets', function (Blueprint $table) {
            $table->dropForeign(['defense_id']);
            $table->dropForeign(['planet_id']);
        });
        Schema::dropIfExists('defense_planets');
    }
};
