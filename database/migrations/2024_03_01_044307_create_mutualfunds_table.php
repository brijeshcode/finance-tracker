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
        Schema::create('mutualfunds', function (Blueprint $table) {
            $table->id();
            $table->string('name',250);
            $table->string('type',20)->default('equity');
            $table->string('market_cap',30)->default('large cap');
            $table->string('expense_ratio',10)->nullable();
            $table->string('exit_load',10)->nullable();
            $table->string('ltcg_tax_percent',10)->nullable()->default(10);
            $table->string('ltcg_days',10)->nullable()->default('365');
            $table->string('stcg_tax_percent',10)->nullable()->default(15);
            $table->string('stcg_days',10)->nullable()->default('1');
            $table->boolean('is_index_fund')->default(false);
            
            $table->text('note')->nullable();
            $table->boolean('active')->default(true);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutualfunds');
    }
};
