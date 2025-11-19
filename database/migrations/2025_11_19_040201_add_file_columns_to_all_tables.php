<?php
// database/migrations/2024_01_01_000000_add_file_columns_to_all_tables.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileColumnsToAllTables extends Migration
{
    public function up()
    {
        // Untuk tabel master
        Schema::table('master', function (Blueprint $table) {
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_original_name')->nullable();
            $table->string('file_size')->nullable();
        });

        // Untuk tabel sub_master
        Schema::table('sub_master', function (Blueprint $table) {
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_original_name')->nullable();
            $table->string('file_size')->nullable();
        });

        // Untuk tabel sub_sections
        Schema::table('sub_sections', function (Blueprint $table) {
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_original_name')->nullable();
            $table->string('file_size')->nullable();
        });
    }

    public function down()
    {
        Schema::table('master', function (Blueprint $table) {
            $table->dropColumn(['file_path', 'file_name', 'file_original_name', 'file_size']);
        });

        Schema::table('sub_master', function (Blueprint $table) {
            $table->dropColumn(['file_path', 'file_name', 'file_original_name', 'file_size']);
        });

        Schema::table('sub_sections', function (Blueprint $table) {
            $table->dropColumn(['file_path', 'file_name', 'file_original_name', 'file_size']);
        });
    }
}