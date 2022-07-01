<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScreenOfacsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('screen_ofacs', function (Blueprint $table) {
            $table->id();
            $table->integer('ent_number');
            $table->string('sdn_name', 350);
            $table->string('sdn_type',12);
            $table->string('program', 50);
            $table->string('title', 200);
            $table->string('call_sign', 8);
            $table->string('vess_type', 25);
            $table->string('tonnage', 14);
            $table->string('grt', 8);
            $table->string('vess_flag', 40);
            $table->string('vess_owner', 150);
            $table->string('remarks', 1000);
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
        Schema::dropIfExists('screen_ofacs');
    }
}
