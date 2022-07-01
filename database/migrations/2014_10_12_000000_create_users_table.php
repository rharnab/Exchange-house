<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->unique()->nullable();
            $table->string('name');
            $table->string('password');
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->string('house_location')->nullable();
            $table->unsignedBigInteger('agent_br_id')->nullable();
            $table->char('agnt_tp')->nullable();
            $table->string('emp_id')->nullable();
            $table->char('status')->nullable();
            $table->unsignedBigInteger('entry_usr_key_id')->nullable();
            $table->date('entry_date')->nullable();
            $table->time('entry_time')->nullable();
            $table->unsignedBigInteger('role_id')->default(2);
            $table->string('ip')->default(0);
            $table->unsignedBigInteger('screening')->nullable();
            $table->integer('login_type')->comment('1=ad 2=agent 3=buru')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
