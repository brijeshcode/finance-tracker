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
        Schema::create('stock_holdings', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('platform_id'); 
            $table->unsignedBigInteger('stock_id'); 
            $table->unsignedBigInteger('stock_transaction_id'); 
            
            
            $table->string('quantity', 20);
            $table->string('rate', 20);
            $table->string('price', 20);  

            $table->string('sold_quantity', 20);
            
            $table->boolean('is_reinvestment')->default(false);
            $table->string('reinvestment_lable')->nullable()->note('reinvestment lables can be: dividend, capital gains');
            
            // it will be true if 365 days completed, and it will be done by scheduler wihch runs every 24 hours
            $table->boolean('long_termed')->default(false); 

            // we will update if all quantites were sold 
            $table->boolean('sold_out')->default(false);


            $table->text('note')->nullable(); 

            $table->softDeletes();
            $table->timestamps();


            $table->index('user_id');
            $table->index('platform_id');
            $table->index('stock_transaction_id');
            $table->index('sold_out');
            $table->index('long_termed'); 
            $table->index('is_reinvestment');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_holdings');
    }
};
