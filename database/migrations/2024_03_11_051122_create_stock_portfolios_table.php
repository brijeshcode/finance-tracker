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
        Schema::create('stock_portfolios', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('stock_id'); 
            
            $table->string('quantity', 20);
            $table->string('avg_rate', 20);
            
            // avg_rate * quantity
            $table->string('invested_value', 20);

            $table->integer('long_term_quantities')->default(0); // quantites which have been completed 365 days
            $table->integer('total_divident_earns')->default(0); // quantites which have been completed 365 days
            

            $table->text('note')->nullable(); 

            $table->softDeletes();
            $table->timestamps();


            $table->index('user_id');
            $table->index('stock_id');  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_portfolios');
    }
};
