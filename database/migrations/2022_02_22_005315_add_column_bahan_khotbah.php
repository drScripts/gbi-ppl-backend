<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnBahanKhotbah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('khotbah', function (Blueprint $table) {
            $table->string('bahan')->after('pembawa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('khotbah', function (Blueprint $table) {
            $table->removeColumn('bahan');
        });
    }
}
