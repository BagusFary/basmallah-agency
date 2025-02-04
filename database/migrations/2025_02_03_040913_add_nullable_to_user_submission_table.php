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
        Schema::table('user_submissions', function (Blueprint $table) {
            $table->string('self_employee_as')->nullable(true)->change();
            $table->integer('avg_monthly_turnover')->default(0)->change();
            $table->integer('instalment_amount')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_submissions', function (Blueprint $table) {
            $table->string('self_employee_as')->nullable(false)->change();
            $table->integer('avg_monthly_turnover')->nullable(false)->change();
            $table->integer('instalment_amount')->nullable(false)->change();
        });
    }
};
