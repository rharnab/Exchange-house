<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_fees', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('country_id')->unsigned();
            $table->decimal('charge', 8, 2);
            $table->decimal('start_amount', 8, 2);
            $table->decimal('end_amount', 8, 2);
            $table->integer('status')->default(0)->comment('0: created, 1: authorized; 2: declined');
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
        Schema::dropIfExists('transaction_fees');
    }
}
