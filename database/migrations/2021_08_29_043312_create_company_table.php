<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->id();
            $table->int('user_id');
            $table->int('state_id');
            $table->int('region_id');
            $table->int('system_settings_id');  # tableName :: service_sector
            $table->string('name');
            $table->string('SSMNo');
            $table->int('postcode');
            $table->text('address');
            $table->string('phoneNumber');
            $table->string('email');
            $table->date('dateEstablished');
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
        Schema::dropIfExists('company');
    }
}
