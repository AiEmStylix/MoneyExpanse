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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            // Set null on deleted
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->date('date');
            $table->decimal('amount', 15, 2);
            $table->string('payee')->nullable();
            $table->string('description')->nullable();
            $table->boolean('inflow')->default(false);

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
