<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('child_personal_information', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('health_worker_id');
            $table->string('municipality');
            $table->string('barangay');
            $table->string('sitio');
            $table->string('lastname');
            $table->string('firstname');
            $table->string('middlename');
            $table->date('birthday');
            $table->enum('sex', ['Male', 'Female']);
            $table->string('mother_lastname');
            $table->string('mother_firstname');
            $table->string('mother_middlename');
            $table->date('mother_birthday');
            $table->string('mother_occupation')->nullable();
            $table->string('father_lastname');
            $table->string('father_firstname');
            $table->string('father_middlename');
            $table->date('father_birthday');
            $table->string('father_occupation')->nullable();
            $table->string('contact_number');
            $table->timestamps();

            $table->foreign('health_worker_id')->references('id')->on('health_workers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_personal_information');
    }
};
