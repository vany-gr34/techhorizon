<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterestsTable extends Migration
{
    public function up()
    {
        Schema::create('interests', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('name')->unique(); // Interest Name (e.g., 'AI', 'Cyber')
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('interests');
    }
}
