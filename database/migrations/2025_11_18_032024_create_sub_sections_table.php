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
            $table->foreignId('sub_master_id')->constrained('sub_master')->onDelete('cascade');
            $table->string('nama');
            $table->date('deadline')->nullable();
            $table->text('catatan')->nullable();
            $table->tinyInteger('progress')->default(0);
            $table->boolean('completed')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sub_sections');
    }
};