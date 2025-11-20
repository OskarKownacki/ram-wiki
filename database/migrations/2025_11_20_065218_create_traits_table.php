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
        Schema::create('traits', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('capacity');
            $table->string('bundle');
            $table->string('type');
            $table->string('rank');
            $table->string('memory_type');
            $table->boolean('ecc_support');
            $table->boolean('ecc_registered');
            $table->string('speed');
            $table->string('frequency');
            $table->string('cycle_latency');
            $table->integer('voltage_v');
            $table->string('bus');
            $table->string('module_build');
            $table->string('module_ammount');
            $table->string('guarancy');
            $table->string('description')->nullable();
            $table->string('manufacturer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traits');
    }
};
