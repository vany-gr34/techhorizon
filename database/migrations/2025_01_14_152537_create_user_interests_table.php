<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInterestsTable extends Migration
{
    public function up()
    {
        Schema::create('user_interests', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign Key to users
            $table->foreignId('interest_id')->constrained()->onDelete('cascade'); // Foreign Key to interests
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_interests');
    }
}
