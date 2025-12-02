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
        Schema::create('rams', function (Blueprint $table)
        {
            $table->id();
            $table->string('product_code')->unique();
            $table->foreignId('hardware_trait_id')->nullable()->constrained('hardware_traits')->onDelete('cascade');
            $table->string('description');
            $table->string('manufacturer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rams');
    }
};
