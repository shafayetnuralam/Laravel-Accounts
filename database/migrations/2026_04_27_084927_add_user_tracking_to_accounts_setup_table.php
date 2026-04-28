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
        Schema::table('accounts_setup', function (Blueprint $table) {
            $table->unsignedBigInteger('insert_id')->nullable()->after('Status');
            $table->unsignedBigInteger('update_id')->nullable()->after('insert_id');
            
            $table->foreign('insert_id')->references('id')->on('users');
            $table->foreign('update_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accounts_setup', function (Blueprint $table) {
            $table->dropForeign(['insert_id']);
            $table->dropForeign(['update_id']);
            $table->dropColumn(['insert_id', 'update_id']);
        });
    }
};
