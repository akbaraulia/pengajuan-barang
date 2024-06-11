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
            $table->unsignedBigInteger('approved_by_manager')->nullable()->after('status');
            $table->foreign('approved_by_manager')->references('id')->on('users');

            $table->unsignedBigInteger('approved_by_finance')->nullable()->after('approved_by_manager');
            $table->foreign('approved_by_finance')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->dropForeign(['approved_by_manager']);
            $table->dropColumn('approved_by_manager');

            $table->dropForeign(['approved_by_finance']);
            $table->dropColumn('approved_by_finance');
        });
    }
};