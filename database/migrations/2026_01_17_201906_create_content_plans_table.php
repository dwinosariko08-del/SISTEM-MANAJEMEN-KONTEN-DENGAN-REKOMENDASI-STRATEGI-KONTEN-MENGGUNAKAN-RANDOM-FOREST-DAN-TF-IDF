<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('content_plans', function (Blueprint $table) {
            $table->id();

            // ASSIGNMENT LEADER
            $table->date('posting_date');
            $table->string('status');          // pending, on progress, done
            $table->string('pillar');
            $table->string('topic');

            // ASSET DARI TIM LAPANGAN
            $table->foreignId('asset_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();

            // CATATAN & REVIEW LEADER
            $table->text('notes_for_creator')->nullable();
            $table->text('revision_notes')->nullable();
            $table->boolean('approved')->nullable();
            // null  = belum dicek
            // true  = approved
            // false = revisi

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_plans');
    }
};
