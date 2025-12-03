<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('servers', function (Blueprint $table)
        {
            $table->foreignId('hardware_trait_id')->nullable()->constrained('hardware_traits')->after('model');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('servers', function (Blueprint $table)
        {
            $table->dropForeign(['hardware_trait_id']);
            $table->dropColumn('hardware_trait_id');
        });
    }
};
