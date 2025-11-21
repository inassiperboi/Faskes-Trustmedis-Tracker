<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sub_master', function (Blueprint $table) {
            $table->foreignId('uploaded_by')->nullable()->after('file_size')->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->after('uploaded_by')->constrained('users')->nullOnDelete();
        });

        Schema::table('sub_sections', function (Blueprint $table) {
            $table->foreignId('uploaded_by')->nullable()->after('file_size')->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->after('uploaded_by')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('sub_master', function (Blueprint $table) {
            $table->dropForeign(['uploaded_by']);
            $table->dropForeign(['updated_by']);
            $table->dropColumn(['uploaded_by', 'updated_by']);
        });

        Schema::table('sub_sections', function (Blueprint $table) {
            $table->dropForeign(['uploaded_by']);
            $table->dropForeign(['updated_by']);
            $table->dropColumn(['uploaded_by', 'updated_by']);
        });
    }
};
