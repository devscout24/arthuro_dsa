<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::connection()->getDriverName();
        if (!in_array($driver, ['mysql', 'mariadb'], true)) {
            // SQLite/Postgres don't have INFORMATION_SCHEMA in the same way,
            // and SQLite treats JSON columns as TEXT anyway.
            return;
        }

        if (!Schema::hasTable('banners') || !Schema::hasColumn('banners', 'image')) {
            return;
        }

        // Check column type
        $column = DB::selectOne(
            "SELECT DATA_TYPE AS data_type 
             FROM INFORMATION_SCHEMA.COLUMNS 
             WHERE TABLE_SCHEMA = DATABASE() 
             AND TABLE_NAME = 'banners' 
             AND COLUMN_NAME = 'image'"
        );

        // If already JSON, skip
        if ($column && strtolower((string) $column->data_type) === 'json') {
            return;
        }

        // Step 1: Add temp column
        if (!Schema::hasColumn('banners', 'image_tmp')) {
            Schema::table('banners', function (Blueprint $table) {
                $table->json('image_tmp')->nullable()->after('tagline');
            });
        }

        // Step 2: Convert existing data safely
        $banners = DB::table('banners')->get();

        foreach ($banners as $banner) {
            if (!$banner->image) {
                $newImage = null;
            } elseif (json_decode($banner->image)) {
                $newImage = $banner->image;
            } else {
                $newImage = json_encode([$banner->image]);
            }

            DB::table('banners')
                ->where('id', $banner->id)
                ->update(['image_tmp' => $newImage]);
        }

        // Step 3: Drop old column
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn('image');
        });

        // Step 4: Rename temp column
        Schema::table('banners', function (Blueprint $table) {
            $table->renameColumn('image_tmp', 'image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::connection()->getDriverName();
        if (!in_array($driver, ['mysql', 'mariadb'], true)) {
            return;
        }

        if (!Schema::hasTable('banners') || !Schema::hasColumn('banners', 'image')) {
            return;
        }

        // Check column type
        $column = DB::selectOne(
            "SELECT DATA_TYPE AS data_type 
             FROM INFORMATION_SCHEMA.COLUMNS 
             WHERE TABLE_SCHEMA = DATABASE() 
             AND TABLE_NAME = 'banners' 
             AND COLUMN_NAME = 'image'"
        );

        // Only run if JSON
        if (!$column || strtolower((string) $column->data_type) !== 'json') {
            return;
        }

        // Step 1: Add temp column
        if (!Schema::hasColumn('banners', 'image_tmp')) {
            Schema::table('banners', function (Blueprint $table) {
                $table->string('image_tmp')->nullable()->after('tagline');
            });
        }

        // Step 2: Convert JSON back to string
        $banners = DB::table('banners')->get();

        foreach ($banners as $banner) {
            $decoded = json_decode($banner->image, true);

            $newImage = is_array($decoded) ? ($decoded[0] ?? null) : $banner->image;

            DB::table('banners')
                ->where('id', $banner->id)
                ->update(['image_tmp' => $newImage]);
        }

        // Step 3: Drop JSON column
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn('image');
        });

        // Step 4: Rename back
        Schema::table('banners', function (Blueprint $table) {
            $table->renameColumn('image_tmp', 'image');
        });
    }
};