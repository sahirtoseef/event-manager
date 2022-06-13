<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Visitor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('manager_id')->nullable();
            $table->integer('event_id')->nullable();
            $table->string('uni_id')->nullable();
            $table->string('watch_list')->nullable();
            $table->string('display_name');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('attendee_type')->nullable();
            $table->string('occupation')->nullable();
            $table->string('company')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->string('photo');
            $table->string('tags')->nullable();
            $table->string('language')->nullable();
            $table->string('location')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('completed_registration')->nullable();
            $table->string('checked_in')->nullable();
            $table->string('terms_and_conditions_accepted')->nullable();
            $table->string('directory_opt_in')->nullable();
            $table->string('directory_opt_out')->nullable();
            $table->string('score')->nullable();
            $table->string('kliks')->nullable();
            $table->string('number_of_connections')->nullable();
            $table->string('registration_status')->nullable();
            $table->string('checkin_time')->nullable();
            $table->string('login_link')->nullable();
            $table->string('wearable_id')->nullable();
            $table->string('wearable_rf_id')->nullable();
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
        Schema::dropIfExists('user_events');
    }
}
