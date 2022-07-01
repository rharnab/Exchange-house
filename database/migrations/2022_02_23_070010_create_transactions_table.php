<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('insKey', 100)->index()->nullable();
            $table->string('orgFileName', 100)->index()->nullable();
            $table->string('uploadedFileName')->nullable();
            $table->char('stLevel')->default(0)->comment('0:Uploaded, 1:Accepted, 2:disburse, 3:declined, 4:cash authorized decline, 5:manual cash waiting, 7:branch cash waiting, 8:agent cash waiting');
            $table->char('trnTp')->comment('A: Account credit, C: Cash');
            $table->bigInteger('agent_code')->unsigned()->nullable();
            $table->string('order_no')->unique();
            $table->string('inv_identity')->index()->nullable();
            $table->string('inv_identity_country')->index()->nullable();
            $table->date('trn_date')->index();
            $table->string('receiver_name', 100);
            $table->string('receiver_country', 100);
            $table->string('receiver_sub_country_level_1', 100)->nullable();
            $table->string('receiver_sub_country_level_2', 100)->nullable();
            $table->string('receiver_sub_country_level_3', 100)->nullable();
            $table->string('receiver_address');
            $table->string('receiver_contact');
            $table->string('receiver_and_sender_relation', 100)->nullable();
            $table->string('purpose_of_sending', 100)->nullable();
            $table->string('receiver_bank_br_routing_number', 20)->nullable();
            $table->string('receiver_bank', 100)->nullable();
            $table->string('receiver_bank_branch', 100)->nullable();
            $table->string('receiver_account_number', 100)->nullable();
            $table->string('sender_name', 100);
            $table->string('sender_country', 100);
            $table->string('sender_sub_country_level_1', 100)->nullable();
            $table->string('sender_sub_country_level_2', 100)->nullable();
            $table->string('sender_sub_country_level_3', 100)->nullable();
            $table->string('sender_address_line');
            $table->string('sender_contact');
            $table->string('sender_email')->nullable();
            $table->string('sender_account_number')->nullable();
            $table->string('sender_transaction_receiving_mode')->nullable();
            $table->integer('sender_transaction_receiving_bank')->nullable();
            $table->integer('sender_ex_h_location')->nullable();
            $table->string('payment_mode', 100)->nullable()->comment('1: Cash Pickup; 2: Bank Deposit');
            $table->string('payment_status', 100)->nullable();
            $table->string('transaction_pin', 100);
            $table->string('payee_agent_or_bank_code', 100)->nullable();
            $table->string('transaction_make_user', 100)->nullable();
            $table->date('agent_received_date')->nullable();
            $table->integer('originated_currency');
            $table->decimal('originated_amount', 8, 2);
            $table->integer('disbursement_currency');
            $table->decimal('disbursement_amount', 8, 2);
            $table->decimal('exchange_rate', 8, 2);
            $table->date('date_of_payment')->nullable();
            $table->decimal('originated_customer_fee', 8, 2)->nullable();
            $table->decimal('originated_amount_fixing_profit',8, 2)->nullable();
            $table->decimal('distributing_commission_amount', 8, 2)->nullable();
            $table->decimal('distributing_commission_currency', 8, 2)->nullable();
            $table->longText('remarks')->nullable();
            $table->string('upload_tag')->nullable();
            $table->string('entry_by', 50);
            $table->date('entry_date');
            $table->string('auth_by', 50)->nullable();
            $table->date('auth_date')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
