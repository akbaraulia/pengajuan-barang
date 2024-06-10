<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTotalPriceToBigint extends Migration
{
    public function up()
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->bigInteger('total_price')->change();
        });
    }

    public function down()
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->integer('total_price')->change();
        });
    }
}