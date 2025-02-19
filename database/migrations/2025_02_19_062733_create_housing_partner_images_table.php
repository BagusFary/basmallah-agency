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
        Schema::create('housing_partner_images', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('housing_partner_id');
            $table->foreign('housing_partner_id')->on('housing_partners')->references('id');
            $table->string('description');
            $table->string('image_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('housing_partner_images');
    }
};
