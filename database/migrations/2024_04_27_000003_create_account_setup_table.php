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
        Schema::create('accounts_setup', function (Blueprint $table) {
            $table->id();
            $table->string('accounts_name');
            $table->string('sector_name');
            $table->string('mobile_no');
            $table->decimal('credit_limit', 10, 2);
            $table->string('category');
            $table->decimal('opening_balance', 10, 2);
            $table->timestamp('CreateDate')->useCurrent();
            $table->timestamp('LastUpdate')->useCurrent()->useCurrentOnUpdate();
            $table->enum('Status', ['Active', 'Inactive'])->default('Active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts_setup');
    }
};
