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
        Schema::create('action_metas', function (Blueprint $table) {
            $table->id();

            $table->string('table_name')->nullable();
            $table->string('model')->nullable();
            $table->string('entry_id')->nullable(); 


            $table->unsignedBigInteger('created_by_id')->default('1')->comment('user who added this enty');
            $table->ipAddress('created_by_ip')->nullable();
            $table->string('created_by_agent',1023)->nullable();

            $table->unsignedBigInteger('updated_by_id')->nullable()->comment('user who last udpated this enty');
            $table->ipAddress('updated_by_ip')->nullable();
            $table->string('updated_by_agent',1023)->nullable();

            $table->unsignedBigInteger('deleted_by_id')->nullable()->comment('user who deleted this enty');
            $table->ipAddress('deleted_by_ip')->nullable();
            $table->string('deleted_by_agent',1023)->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->index('table_name');
            $table->index('model');
            $table->index('created_by_id');
            $table->index('created_at');
            $table->index('updated_by_id');
            $table->index('updated_by_ip');
            $table->index('created_by_ip');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('action_metas');
    }
};
