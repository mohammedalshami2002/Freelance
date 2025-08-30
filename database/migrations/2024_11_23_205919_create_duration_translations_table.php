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
        Schema::create('duration_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->string('duration_name');
            $table->foreignId('duration_id')->references('id')->on('durations')->onDelete('cascade');
            $table->unique(['duration_id','locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('duration_translations');
    }
};
