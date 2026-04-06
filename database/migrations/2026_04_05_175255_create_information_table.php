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
        Schema::create('information', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('email_label')->nullable();
            $table->string('email_icon')->nullable();
            $table->string('email')->nullable();
            $table->string('tagline')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('linkedin_icon')->nullable();
            $table->string('instagram')->nullable();
            $table->string('instagram_icon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('information');
    }
};
