<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_rates', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('from_currency_id')->unsigned()->nullable();
            $table->bigInteger('to_currency_id')->unsigned()->nullable();
            $table->bigInteger('country_id')->unsigned()->nullable();
            $table->bigInteger('bank_id')->unsigned()->nullable();
            $table->decimal('rate_amount', 8,2)->unsigned()->nullable();
            $table->integer('status')->default(0)->comment('0:created, 1:authorized, 2:declined');
            $table->string('entry_by')->nullable();
            $table->date('entry_date')->nullable();
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
        Schema::dropIfExists('currency_rates');
    }
}
