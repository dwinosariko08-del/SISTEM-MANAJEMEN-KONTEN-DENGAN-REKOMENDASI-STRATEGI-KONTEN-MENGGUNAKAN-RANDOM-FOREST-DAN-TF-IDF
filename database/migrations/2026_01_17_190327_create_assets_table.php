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
      Schema::create('assets', function (Blueprint $table) {
    $table->id();
    $table->string('nama_client');
    $table->string('jenis_project');
    $table->string('lokasi');
    $table->text('alamat')->nullable();
    $table->string('gdrive_link');
    $table->text('keterangan')->nullable();
    $table->foreignId('uploaded_by')->constrained('users');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
