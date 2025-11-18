<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sub_master', function (Blueprint $table) {
            $table->id();

            $table->foreignId('master_id')
                  ->constrained('master')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();

            $table->string('nama');
            $table->date('deadline')->nullable();
            $table->text('catatan')->nullable();
            $table->unsignedTinyInteger('progress')->default(0);
            $table->boolean('completed')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_master');
    }
};
