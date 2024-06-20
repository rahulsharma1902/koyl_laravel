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
        Schema::create('doctor_metas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); 
            $table->string('practice')->nullable();
            $table->text('location')->nullable();
            $table->longtext('doctor_type')->nullable(); 
            $table->tinyInteger('status')->default(1); // 0 => active  1 => pending
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_metas');
    }
};
