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
            $table->boolean('ecc_registered')->nullable()->change();
            $table->string('cycle_latency')->nullable()->change();
            $table->integer('voltage_v')->nullable()->change();
            $table->string('bus')->nullable()->change();
            $table->string('module_build')->nullable()->change();
            $table->string('module_ammount')->nullable()->change();
            $table->string('guarancy')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('be_nullable_if_not_essential', function (Blueprint $table) {
            //
        });
    }
};
