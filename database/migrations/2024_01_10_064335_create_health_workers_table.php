<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHealthWorkersTable extends Migration
{
    public function up()
    {
        Schema::create('health_workers', function (Blueprint $table) {
            $table->id();
            $table->string('status'); 
            $table->string('role');
            $table->string('profile_picture');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('municipality');
            $table->string('barangay');
            $table->string('sitio');
            $table->string('email')->unique();
            $table->string('contact_number');
            $table->string('password');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('health_workers');
    }
}
