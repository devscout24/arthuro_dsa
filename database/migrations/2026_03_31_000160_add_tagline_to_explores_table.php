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
        if (!Schema::hasColumn('explores', 'tagline')) {
            Schema::table('explores', function (Blueprint $table) {
                $table->string('tagline')->nullable()->after('image');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('explores', 'tagline')) {
            Schema::table('explores', function (Blueprint $table) {
                $table->dropColumn('tagline');
            });
        }
    }
};
