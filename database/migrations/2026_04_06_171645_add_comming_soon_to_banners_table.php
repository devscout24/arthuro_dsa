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
        if (!Schema::hasColumn('banners', 'comming_soon')) {
            Schema::table('banners', function (Blueprint $table) {
                $table->string('comming_soon')->nullable()->after('id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('banners', 'comming_soon')) {
            Schema::table('banners', function (Blueprint $table) {
                $table->dropColumn('comming_soon');
            });
        }
    }
};
