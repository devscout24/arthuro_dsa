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
        Schema::table('alreadies', function (Blueprint $table) {
            if (!Schema::hasColumn('alreadies', 'tag_head')) {
                $table->text('tag_head')->nullable()->after('description');
            }
            if (!Schema::hasColumn('alreadies', 'tag_body')) {
                $table->text('tag_body')->nullable()->after('tag_head');
            }
            if (!Schema::hasColumn('alreadies', 'tag_number')) {
                $table->text('tag_number')->nullable()->after('tag_body');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alreadies', function (Blueprint $table) {
            if (Schema::hasColumn('alreadies', 'tag_number')) {
                $table->dropColumn('tag_number');
            }
            if (Schema::hasColumn('alreadies', 'tag_body')) {
                $table->dropColumn('tag_body');
            }
            if (Schema::hasColumn('alreadies', 'tag_head')) {
                $table->dropColumn('tag_head');
            }
        });
    }
};
