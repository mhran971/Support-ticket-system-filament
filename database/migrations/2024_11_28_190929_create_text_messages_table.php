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
        Schema::create('text_messages', function (Blueprint $table) {
            $table->id();
            $table->text('message');
            $table->text('response')->nullable();
            $table->foreignId('sent_to')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('sent_by')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('status',\App\Models\TextMessage::STATUS)->default('PENDING');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('text_messages');
    }
};
