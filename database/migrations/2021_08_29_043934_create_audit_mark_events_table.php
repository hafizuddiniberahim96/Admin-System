<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditMarkEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_mark_events', function (Blueprint $table) {
            $table->id();
            $table->int('event_id');
            $table->int('auditor_id');
            $table->int('user_id');
            $table->int('audit_item_id');
            $table->int('mark');
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('audit_mark_events');
    }
}
