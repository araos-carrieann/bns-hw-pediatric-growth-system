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
        Schema::create('child_health_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('child_id');
            $table->unsignedBigInteger('health_worker_id');
            $table->decimal('weight', 5, 2);
            $table->decimal('height', 5, 2);
            $table->decimal('bmi', 5, 2);
            $table->string('bmi_classification');
            $table->string('medical_condition')->nullable();
            $table->string('vaccine_received')->nullable();
            $table->integer('age');
            $table->timestamps();
            $table->foreign('health_worker_id')->references('id')->on('health_workers');
            $table->foreign('child_id')->references('id')->on('child_personal_information');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_health_records');
    }
};
