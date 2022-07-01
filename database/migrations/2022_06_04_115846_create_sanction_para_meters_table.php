<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSanctionParaMetersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sanction_para_meters', function (Blueprint $table) {
            $table->id();
            $table->decimal('name',8,2);
            $table->decimal('father_name',8,2)->nullable();
            $table->decimal('mother_name',8,2)->nullable();
            $table->decimal('place_of_birth',8,2)->nullable();
            $table->decimal('country',8,2)->nullable();
            $table->decimal('dob',8,2)->nullable();
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
        Schema::dropIfExists('sanction_para_meters');
    }
}
