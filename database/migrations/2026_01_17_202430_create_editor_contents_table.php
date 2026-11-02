<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('editor_contents', function (Blueprint $table) {
            $table->id();

            // RELASI KE ASSIGNMENT LEADER
            $table->foreignId('content_plan_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // DATA KERJA EDITOR
            $table->string('post_type');               // reels, feed, tiktok
            $table->string('content_title');
            $table->text('script_brief')->nullable();
            $table->text('reference')->nullable();
            $table->text('caption')->nullable();
            $table->string('hashtag')->nullable();
            $table->string('talent')->nullable();
            $table->string('editor_name');
            $table->string('preview_thumbnail')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('editor_contents');
    }
};
