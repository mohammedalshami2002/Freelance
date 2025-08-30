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
        Schema::create('profile__service_providers', function (Blueprint $table) {
            $table->id();
            $table->string('profile');
            $table->string('phone_number');
            $table->string('university_name');
            $table->string('specialization');
            $table->boolean('authenticated')->default(false);
            $table->smallInteger('review')->default(0);
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('categorie_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile__service_providers');
    }
};
