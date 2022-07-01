<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_infos', function (Blueprint $table) {
            $table->id();
            $table->string('id_flag')->nullable();
            $table->string('corporate_address');
            $table->bigInteger('country_id')->unsigned();
            $table->string('contact')->unique();
            $table->string('email')->unique();
            $table->string('webLink')->nullable();
            $table->char('bnkOrg', 1)->nullable();
            $table->string('bankCode')->nullable();
            $table->string('coverFundGL')->nullable();
            $table->integer('status')->default(0)->comment('0:created; 1:authorized; 2:declined');
            $table->string('entry_by');
            $table->date('entry_date');
            $table->string('auth_by')->nullable();
            $table->date('auth_date')->nullable();
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
        Schema::dropIfExists('agent_infos');
    }
}
