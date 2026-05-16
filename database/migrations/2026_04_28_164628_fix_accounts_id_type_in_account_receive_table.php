<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('account_receive', function (Blueprint $table) {

            // Drop old foreign key first
            $table->dropForeign(['accounts_id']);

            // Modify column if needed
            $table->unsignedBigInteger('accounts_id')->change();

            // Re-add foreign key
            $table->foreign('accounts_id')
                ->references('id')
                ->on('accounts_setup')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        //
    }
};