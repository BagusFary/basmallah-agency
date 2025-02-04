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
        Schema::create('user_submissions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('housing_partner_id');
            $table->string('email');
            $table->string('phone')->unique();
            $table->string('name')->index();
            $table->string('id_card', 50)->index();
            $table->text('address');
            $table->enum('employment_status', ['self_employees', 'civil_servants', 'employees'])->default('self_employees');
            $table->string('self_employee_as');
            $table->integer('avg_monthly_turnover');
            $table->boolean('has_instalment');
            $table->integer('instalment_amount');
            $table->string('referral_code')->index();
            $table->foreign('housing_partner_id')->on('housing_partners')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_submissions');
    }
};
