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
        if (! Schema::hasColumn('information', 'email_icon')) {
            Schema::table('information', function (Blueprint $table) {
                $table->string('email_icon')->nullable()->after('email_label');
            });
        }

        if (! Schema::hasColumn('information', 'linkedin_icon')) {
            Schema::table('information', function (Blueprint $table) {
                $table->string('linkedin_icon')->nullable()->after('linkedin');
            });
        }

        if (! Schema::hasColumn('information', 'instagram_icon')) {
            Schema::table('information', function (Blueprint $table) {
                $table->string('instagram_icon')->nullable()->after('instagram');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('information', 'email_icon')) {
            Schema::table('information', function (Blueprint $table) {
                $table->dropColumn('email_icon');
            });
        }

        if (Schema::hasColumn('information', 'linkedin_icon')) {
            Schema::table('information', function (Blueprint $table) {
                $table->dropColumn('linkedin_icon');
            });
        }

        if (Schema::hasColumn('information', 'instagram_icon')) {
            Schema::table('information', function (Blueprint $table) {
                $table->dropColumn('instagram_icon');
            });
        }
    }
};
