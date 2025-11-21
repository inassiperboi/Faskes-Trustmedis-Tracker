<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fitur', function (Blueprint $table) {
            $table->id();
            $table->string('no_assessment')->unique();
            $table->text('judul');
            $table->date('target_uat')->nullable();
            $table->date('target_due_date')->nullable();
            $table->string('link')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fitur');
    }
};
