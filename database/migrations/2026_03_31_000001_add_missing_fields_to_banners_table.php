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
        Schema::table('banners', function (Blueprint $table) {
            if (!Schema::hasColumn('banners', 'button')) {
                $table->string('button')->nullable();
            }

            if (!Schema::hasColumn('banners', 'tagline')) {
                $table->string('tagline')->nullable();
            }

            if (!Schema::hasColumn('banners', 'image')) {
                $table->string('image')->nullable();
            }

            if (!Schema::hasColumn('banners', 'career')) {
                $table->string('career')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            if (Schema::hasColumn('banners', 'career')) {
                $table->dropColumn('career');
            }

            if (Schema::hasColumn('banners', 'image')) {
                $table->dropColumn('image');
            }

            if (Schema::hasColumn('banners', 'tagline')) {
                $table->dropColumn('tagline');
            }

            if (Schema::hasColumn('banners', 'button')) {
                $table->dropColumn('button');
            }
        });
    }
};
