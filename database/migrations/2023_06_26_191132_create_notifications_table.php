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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->string('body');
            $table->string('resources');
            $table->string('defenses')->nullable();
            $table->integer('solar_system_position')->nullable();
            $table->integer('galaxy_position')->nullable();
            $table->enum('type', ['spy', 'attack', 'defense','info','expedition'])->default('info');
            $table->boolean('read')->default(0);
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('notifications');
    }
};
