<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->int('system_settings_id'); #tableName :: program_category
            $table->string('name');
            $table->string('logo');
            $table->string('event_mode');
            $table->string('location');
            $table->string('bannerImg');
            $table->int('seats');
            $table->double('fee');
            $table->boolean('isAward');
            $table->timestamp('register_before');
            $table->timestamp('date_start');
            $table->timestamp('date_end');
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
        Schema::dropIfExists('events');
    }
}
