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
        Schema::create('stock_sales', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('platform_id'); 
            $table->unsignedBigInteger('stock_id'); 
            
            $table->string('quantity', 20)->default(0);
            $table->string('rate', 20)->default(0);
            $table->string('price', 20)->default(0);  
            
            $table->string('net_profit', 20)->default(0);
            $table->string('transaction_fee', 20)->default(0);  
            
            

            $table->text('note')->nullable(); 

            $table->softDeletes();
            $table->timestamps();


            $table->index('user_id');
            $table->index('stock_id');  
            $table->index('platform_id');  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_sales');
    }
};
