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
        if (!Schema::hasColumn('anythings', 'tagline')) {
            Schema::table('anythings', function (Blueprint $table) {
                $table->string('tagline')->nullable()->after('description');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('anythings', 'tagline')) {
            Schema::table('anythings', function (Blueprint $table) {
                $table->dropColumn('tagline');
            });
        }
    }
};
