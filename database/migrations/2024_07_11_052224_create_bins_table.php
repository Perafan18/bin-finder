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
        Schema::create('bins', function (Blueprint $table) {
            $table->id();
            $table->string('bin')->unique(); // 000000
            $table->string('type')->nullable(); // credit, debit
            $table->string('brand')->nullable(); // visa, mastercard
            $table->string('bank')->nullable(); // Bank of America
            $table->string('country')->nullable(); // US
            $table->foreignId('provider_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bins');
    }
};
