<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('master', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faskes_id')
                  ->constrained('faskes')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->string('nama');              // 1. Nama Tahapan
            $table->date('deadline')->nullable(); // 2. Deadline  
            $table->text('catatan')->nullable();  // 3. Catatan

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master');
    }
};