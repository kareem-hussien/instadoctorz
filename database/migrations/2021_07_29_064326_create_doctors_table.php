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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->double('experience')->nullable();
            $table->string('prefix')->nullable();
            $table->string('education')->nullable();
            $table->string('availability')->nullable();
            $table->boolean('can_start')->default(0)->nullable();
            $table->string('start_date')->nullable();
            $table->string('services_can_be_performed_online')->nullable();
            $table->string('urgent_care')->nullable();
            $table->string('chronic_care')->nullable();
            $table->string('child_care')->nullable();
            $table->string('sexual_health')->nullable();
            $table->string('skin_and_hair')->nullable();
            $table->string('mental_health')->nullable();
            $table->string('preventive_health')->nullable();
            $table->string('services')->nullable();
            $table->string('sub_urgent_care')->nullable();
            $table->string('sub_chronic_care')->nullable();
            $table->string('sub_sexual_health')->nullable();
            $table->string('sub_skin_and_hair')->nullable();
            $table->string('sub_mental_health')->nullable();
            $table->string('sub_preventive_health')->nullable();

            
            $table->timestamps();

            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
