<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sub_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_master_id')
                  ->constrained('sub_master')
                  ->onDelete('cascade');
            
            $table->string('nama');
            $table->date('deadline')->nullable();
            $table->text('catatan')->nullable();
            $table->enum('status', ['pending', 'selesai'])->default('pending'); // Kolom status baru
            
            // File upload columns
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_original_name')->nullable();
            $table->string('file_size')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sub_sections');
    }
};