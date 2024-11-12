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
        Schema::create('corporate_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_id')->constrained();
            $table->enum('type', ['dividend', 'bonus', 'split']);
            $table->decimal('value', 10, 2)->nullable(); // for dividend
            $table->integer('bonus_ratio')->nullable(); // for bonus
            $table->integer('split_ratio')->nullable(); // for split
            $table->date('record_date');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corporate_actions');
    }
};