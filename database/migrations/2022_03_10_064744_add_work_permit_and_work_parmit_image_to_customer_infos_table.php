<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWorkPermitAndWorkParmitImageToCustomerInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_infos', function (Blueprint $table) {
            $table->string('work_permit_id_number')->nullable()->after('occupation_id');
            $table->string('work_permit_id_image')->nullable()->after('work_permit_id_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_infos', function (Blueprint $table) {
            $table->dropColumn('work_permit_id_number');
            $table->dropColumn('work_permit_id_image');
        });
    }
}
