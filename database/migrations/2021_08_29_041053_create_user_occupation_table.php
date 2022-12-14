<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserOccupationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_occupation', function (Blueprint $table) {
            $table->id();
            $table->int('user_id');
            $table->string('eduLevel')->nullable();
            $table->string('occupation')->nullable();
            $table->string('position')->nullable();
            $table->string('expertise')->nullable();
            $table->year('start_year');
            $table->year('end_year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_occupation');
    }
}
