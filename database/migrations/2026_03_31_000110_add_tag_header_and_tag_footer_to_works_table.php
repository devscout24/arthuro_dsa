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
        Schema::table('works', function (Blueprint $table) {
            if (!Schema::hasColumn('works', 'tag_header')) {
                $table->string('tag_header')->nullable()->after('description');
            }

            if (!Schema::hasColumn('works', 'tag_footer')) {
                $table->string('tag_footer')->nullable()->after('tag_header');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('works', function (Blueprint $table) {
            if (Schema::hasColumn('works', 'tag_footer')) {
                $table->dropColumn('tag_footer');
            }

            if (Schema::hasColumn('works', 'tag_header')) {
                $table->dropColumn('tag_header');
            }
        });
    }
};
