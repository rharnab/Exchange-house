<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountOpeningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_openings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id')->unsigned();
            $table->bigInteger('branch_id')->unsigned();
            $table->bigInteger('account_type_id')->unsigned();
            $table->decimal('interest_rate');
            $table->string('account_no');
            $table->string('signature_image');
            $table->decimal('probably_monthly_income', 8, 2)->nullable();
            $table->decimal('probably_monthly_transaction', 8, 2)->nullable();
            $table->string('nominee_name')->nullable();
            $table->string('nominee_nid_number')->nullable();
            $table->text('nominee_address')->nullable();
            $table->string('relation_with_nominee')->nullable();
            $table->date('nominee_dob')->nullable();
            $table->string('nominee_age');
            $table->string('nominee_father_name')->nullable();
            $table->string('nominee_mother_name')->nullable();
            $table->string('nominee_contact_no')->nullable();
            $table->integer('status')->default(0)->comment('0: created, 1: authorize; 2: declined');
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
        Schema::dropIfExists('account_openings');
    }
}
