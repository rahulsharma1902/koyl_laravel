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
        Schema::create('patient_metas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); 
            $table->string('weight')->nullable();
            $table->integer('age')->nullable();
            $table->string('race')->nullable();
            $table->enum('sex', ['male', 'female', 'other'])->nullable(); 
            $table->text('allergies')->nullable();
            $table->unsignedBigInteger('doctor_id')->nullable(); 
            $table->text('location')->nullable(); 
            $table->tinyInteger('status')->default(1); // 0 => active  1 => pending
            // $table->enum('status', ['active', 'pending', 'other']);
            $table->timestamps();

            // $table->foreign('patient_id')->references('id')->on('patients')->onDelete('set null');
            // $table->foreign('doctor_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_metas');
    }
};
