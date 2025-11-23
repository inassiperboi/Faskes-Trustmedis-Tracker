<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileColumnsToAllTables extends Migration
{
    public function up()
    {
        // Untuk tabel master (tambah kolom file)
        if (!Schema::hasColumn('master', 'file_path')) {
            Schema::table('master', function (Blueprint $table) {
                $table->string('file_path')->nullable();
                $table->string('file_name')->nullable();
                $table->string('file_original_name')->nullable();
                $table->string('file_size')->nullable();
            });
        }

        // Untuk tabel sub_master (tambah kolom file)
        if (!Schema::hasColumn('sub_master', 'file_path')) {
            Schema::table('sub_master', function (Blueprint $table) {
                $table->string('file_path')->nullable();
                $table->string('file_name')->nullable();
                $table->string('file_original_name')->nullable();
                $table->string('file_size')->nullable();
            });
        }

        // HAPUS BAGIAN INI - karena sub_sections sudah ada kolom file
        // Untuk tabel sub_sections - SUDAH ADA di migrasi sebelumnya
    }

    public function down()
    {
        // Hanya drop dari tabel yang benar-benar kita tambahkan
        Schema::table('master', function (Blueprint $table) {
            $table->dropColumn(['file_path', 'file_name', 'file_original_name', 'file_size']);
        });

        Schema::table('sub_master', function (Blueprint $table) {
            $table->dropColumn(['file_path', 'file_name', 'file_original_name', 'file_size']);
        });

        // Jangan drop dari sub_sections karena sudah ada sebelumnya
    }
}