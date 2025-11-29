<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('hardware_traits', function (Blueprint $table) {
            $table->dropColumn(['manufacturer', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hardware_traits', function (Blueprint $table) {
            $table->string('manufacturer');
            $table->string('description')->nullable();
        });
    }
};
