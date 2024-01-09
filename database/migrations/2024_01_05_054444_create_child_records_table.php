<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('child_records', function (Blueprint $table) {
            $table->id();
            $table->string('municipal');
            $table->string('barangay');
            $table->string('sitio');
            $table->string('lastname');
            $table->string('firstname');
            $table->string('middlename');
            $table->date('birthday');
            $table->enum('sex', ['Male', 'Female']); 
            $table->decimal('weight', 8, 2);
            $table->decimal('height', 8, 2);
            $table->decimal('bmi', 8, 2); 
            $table->string('bmi_classification'); 
            $table->string('medical_condition')->nullable();
            $table->string('vaccine_received')->nullable(); 
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
        });
    }

    public function down()
    {
        Schema::dropIfExists('children_records');
    }
};
