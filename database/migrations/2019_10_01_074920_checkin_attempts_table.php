<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CheckinAttemptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkin_attempts', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->integer('manager_id')->nullable();
            $table->integer('visitor_id')->nullable();
            $table->string('location')->nullable();
            $table->string('qr_code')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('checkin_attempts');
    }
}
