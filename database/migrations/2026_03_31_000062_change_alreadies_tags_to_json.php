<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Make tag columns real JSON columns where supported (e.g., MySQL 5.7+).
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement('ALTER TABLE `alreadies` MODIFY `tag_head` JSON NULL');
        DB::statement('ALTER TABLE `alreadies` MODIFY `tag_body` JSON NULL');
        DB::statement('ALTER TABLE `alreadies` MODIFY `tag_number` JSON NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        // Revert back to TEXT columns.
        DB::statement('ALTER TABLE `alreadies` MODIFY `tag_head` TEXT NULL');
        DB::statement('ALTER TABLE `alreadies` MODIFY `tag_body` TEXT NULL');
        DB::statement('ALTER TABLE `alreadies` MODIFY `tag_number` TEXT NULL');
    }
};
