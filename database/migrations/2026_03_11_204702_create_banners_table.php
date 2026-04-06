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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('comming_soon')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('button')->nullable();
            $table->string('tagline')->nullable();
            $table->json('image')->nullable();
            $table->string('career')->nullable();
            $table->json('features')->nullable();
            $table->json('icons')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
