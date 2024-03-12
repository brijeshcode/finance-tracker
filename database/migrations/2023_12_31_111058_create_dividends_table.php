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
        Schema::create('dividends', function (Blueprint $table) {
            
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('investment_id');
            $table->unsignedBigInteger('user_id');
            $table->float('percent');
            $table->integer('quantity');
            $table->string('rate', 20); 
            $table->string('total', 20); 

            $table->text('note')->nullable(); 
            
            $table->softDeletes();
            $table->timestamps(); 
            
            $table->index('user_id');
            $table->index('investment_id');
            $table->index('date');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dividends');
    }
};
