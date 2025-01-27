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
        Schema::create('housing_partners', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUlid('user_id');
            $table->string('code')->unique();
            $table->string('image_url');
            $table->string('name')->index();
            $table->string('phone', 20)->unique();
            $table->string('email');
            $table->integer('booking_fee')->default(0);
            $table->integer('available')->default(0);
            $table->integer('down_payment')->default(0);
            $table->foreign('user_id')->on('users')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('housing_partners');
    }
};
