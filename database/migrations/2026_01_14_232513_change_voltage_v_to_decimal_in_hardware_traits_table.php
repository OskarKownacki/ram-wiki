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
        Schema::table('hardware_traits', function (Blueprint $table)
        {
            $table->decimal('voltage_v', 4, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hardware_traits', function (Blueprint $table)
        {
            $table->integer('voltage_v')->nullable()->change();
        });
    }
};
