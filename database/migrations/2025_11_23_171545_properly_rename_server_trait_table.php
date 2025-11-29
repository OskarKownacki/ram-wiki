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
        Schema::rename('server_trait', 'hardware_trait_server');
        Schema::table('hardware_trait_server', function (Blueprint $table) {
            $table->renameColumn('trait_id', 'hardware_trait_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('hardware_trait_server', 'server_trait');
        Schema::table('server_trait', function (Blueprint $table) {
            $table->renameColumn('hardware_trait_id', 'trait_id');
        });
    }
};
