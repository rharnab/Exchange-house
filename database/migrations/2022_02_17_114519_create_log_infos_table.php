<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_infos', function (Blueprint $table) {
            $table->id();
            $table->string('model_name', 100);
            $table->string('operation_name', 100);
            $table->string('status', 100);
            $table->string('reason')->nullable();
            $table->longText('previous_data')->nullable();
            $table->string('ip_address', 100)->nullable();
            $table->string('entry_by', 100);
            $table->date('entry_date')->nullable();
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
        Schema::dropIfExists('log_infos');
    }
}
