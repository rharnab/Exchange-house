<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExHBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ex_h_branches', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->unique();
            $table->text('location')->nullable();
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
        Schema::dropIfExists('ex_h_branches');
    }
}
