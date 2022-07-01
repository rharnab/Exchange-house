<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_infos', function (Blueprint $table) {
            $table->id();
            $table->string('name',50)->unique();
            $table->string('short_name', 30)->nullable();
            $table->bigInteger('currency_id')->unsigned();
            $table->string('entry_by')->nullable();
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
        Schema::dropIfExists('country_infos');
    }
}
