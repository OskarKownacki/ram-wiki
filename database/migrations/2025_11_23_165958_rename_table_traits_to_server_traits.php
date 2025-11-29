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
       Schema::rename('server_traits', 'server_trait'); 
       Schema::rename('traits', 'server_traits');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('server_trait', 'server_traits');
        Schema::rename('server_traits', 'traits');
    }
};
