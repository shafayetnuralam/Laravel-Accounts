<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
     Schema::table('account_receive', function (Blueprint $table) {
    $table->foreign('accounts_id')
          ->references('id')
          ->on('accounts_setup')
          ->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('account_receive', function (Blueprint $table) {
            //
        });
    }
};
