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
        Schema::create('investor_platforms', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('platform_id');
            $table->date('registration_date')->nullable(); 
            
            $table->text('note')->nullable();
            $table->boolean('active')->default(true);

            $table->softDeletes();
            $table->timestamps();

            $table->index('user_id');
            $table->index('platform_id'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investor_platforms');
    }
};
