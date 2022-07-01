<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionAcceptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_accepts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('trn_id')->unsigned();
            $table->char('trnTp', 10)->nullable();
            $table->string('accountNo',100)->nullable();
            $table->string('accountName')->nullable();
            $table->integer('bnkCode')->nullable();
            $table->integer('brCode')->nullable();
            $table->string('selDistCode', 100)->nullable();
            $table->string('acceptBy', 100)->nullable();
            $table->date('acceptDate')->nullable()->nullable();
            $table->string('authBy', 100)->nullable();
            $table->date('authDate')->nullable()->nullable();
            $table->string('sts', 50)->comment('0: accepted, 1: Authorized, 2: disbursed');
            $table->date('stsDate')->nullable();
            $table->decimal('disburseAmt', 8, 2)->nullable();
            $table->string('disburseThru', 100)->comment('1: cash, 2: eft, 3: rtgs, 4: Own bank ACC')->nullable();
            $table->string('disburseBranch', 100);
            $table->integer('disburseAgent')->nullable();
            $table->integer('disburseAgentBr')->nullable();
            $table->string('disburseBy', 100)->nullable();
            $table->date('disburseDate')->nullable();
            $table->time('disburseTime')->nullable();
            $table->integer('cashTr_ID_tp')->nullable();
            $table->string('cashTr_IDN', 100)->nullable();
            $table->string('cashTr_bearerContact', 100)->nullable();
            $table->string('cashTr_Rem', 500)->nullable();
            $table->text('oprCode')->nullable();
            $table->integer('slab')->default(0);
            $table->string('fileReference', 100)->nullable();
            $table->integer('voucher_print')->default(0);
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
        Schema::dropIfExists('transaction_accepts');
    }
}
