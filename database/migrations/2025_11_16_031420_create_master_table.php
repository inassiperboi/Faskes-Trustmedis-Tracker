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

            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->date('deadline')->nullable();
            $table->text('catatan')->nullable();
            $table->unsignedTinyInteger('progress')->default(0);
            $table->boolean('completed')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master');
    }
};
