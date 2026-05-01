<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('account_payment', function (Blueprint $table) {
            $table->unsignedBigInteger('accounts_id')->change();
        });

        Schema::table('account_payment', function (Blueprint $table) {
            $table->foreign('accounts_id')
                  ->references('id')
                  ->on('accounts_setup')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('account_payment', function (Blueprint $table) {
            $table->dropForeign(['accounts_id']);
        });
    }
};