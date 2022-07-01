<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_infos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('country_id')->unsigned();
            $table->bigInteger('city_id')->unsigned()->nullable();
            $table->bigInteger('id_type')->unsigned()->nullable();
            $table->date('expire_date')->nullable();
            $table->bigInteger('occupation_id')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('dob')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('permanent_address')->nullable();
            $table->text('present_address')->nullable();
            $table->string('customer_type');
            $table->string('id_number')->nullable()->unique();
            $table->string('doc_name')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_address')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('entry_by')->nullable();
            $table->integer('entry_by_house_location')->nullable();
            $table->date('entry_date')->nullable();
            $table->string('auth_by')->nullable();
            $table->date('auth_date')->nullable();
            $table->integer('status')->default(0)->comment('0:created, 1:authorized; 2:declined');
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('customer_infos');
    }
}
