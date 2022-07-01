<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSanctionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sanction_logs', function (Blueprint $table) {
            $table->id();
            $table->string('operation_name', 100);
            $table->bigInteger('operation_id')->unsigned();
            $table->bigInteger('transaction_id')->unsigned()->nullable();
            $table->string('type', 100);
            $table->string('log_status', 100);
            $table->decimal('sanction_value', 8,2);
            $table->string('sanction_table', 100)->nullable();
            $table->text('sanction_remarks')->nullable();
            $table->string('ip_address', 100);
            $table->string('entry_by', 100);
            $table->date('entry_date');
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
        Schema::dropIfExists('sanction_logs');
    }
}
