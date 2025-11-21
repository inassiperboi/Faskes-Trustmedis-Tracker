<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('master_tahapan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');              // Nama tahapan standar
            $table->integer('urutan')->default(0); // Urutan tahapan
            $table->text('keterangan')->nullable(); // Keterangan tahapan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_tahapan');
    }
};
