<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */

    public function up()
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->unsignedBigInteger('rejected_by')->nullable();
            $table->foreign('rejected_by')->references('id')->on('users');
        });
    }

    /**
         * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->dropForeign(['rejected_by']);
            $table->dropColumn('rejected_by');
        });
    }
};