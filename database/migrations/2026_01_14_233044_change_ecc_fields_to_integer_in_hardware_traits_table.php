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
        DB::statement('ALTER TABLE hardware_traits ALTER COLUMN ecc_support TYPE integer USING ecc_support::integer');
        DB::statement('ALTER TABLE hardware_traits ALTER COLUMN ecc_registered TYPE integer USING ecc_registered::integer');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE hardware_traits ALTER COLUMN ecc_support TYPE boolean USING ecc_support::boolean');
        DB::statement('ALTER TABLE hardware_traits ALTER COLUMN ecc_registered TYPE boolean USING ecc_registered::boolean');
    }
};
