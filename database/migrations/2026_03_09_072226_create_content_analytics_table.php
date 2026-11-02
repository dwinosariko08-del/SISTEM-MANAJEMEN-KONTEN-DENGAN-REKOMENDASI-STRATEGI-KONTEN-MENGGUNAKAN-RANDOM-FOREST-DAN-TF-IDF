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
      Schema::create('content_analytics', function (Blueprint $table) {
    $table->id();

    $table->foreignId('content_plan_id')->constrained()->cascadeOnDelete();

    $table->enum('platform', ['instagram', 'tiktok']);

    $table->integer('views')->default(0);
    $table->integer('likes')->default(0);
    $table->integer('comments')->default(0);
    $table->integer('shares')->default(0);

    $table->integer('posting_hour')->nullable();
    $table->string('posting_day')->nullable();

    $table->integer('caption_length')->nullable();
    $table->integer('hashtag_count')->nullable();

    $table->decimal('engagement_rate', 8,2)->nullable();
    $table->decimal('engagement_score', 10,2)->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_analytics');
    }
};
