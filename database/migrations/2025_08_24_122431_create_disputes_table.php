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
        Schema::create('disputes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade'); 
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade'); 
            $table->foreignId('service_provider_id')->constrained('users')->onDelete('cascade'); 
            $table->text('initial_reason'); // السبب الأولي لفتح النزاع
            $table->string('status')->default('open'); // حالة النزاع: open, pending_response, under_review, resolved
            $table->timestamp('opened_at')->useCurrent(); 
            $table->timestamp('resolved_at')->nullable(); 
            $table->foreignId('resolved_by_user_id')->nullable()->constrained('users')->onDelete('set null'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disputes');
    }
};
