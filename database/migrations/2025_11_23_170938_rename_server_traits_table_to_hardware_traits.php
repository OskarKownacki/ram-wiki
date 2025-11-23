<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('server_traits', 'hardware_traits');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('hardware_traits', 'server_traits');
    }
};
