<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('master', function (Blueprint $table) {
            $table->foreignId('master_tahapan_id')
                  ->nullable()
                  ->after('faskes_id')
                  ->constrained('master_tahapan')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('master', function (Blueprint $table) {
            $table->dropForeign(['master_tahapan_id']);
            $table->dropColumn('master_tahapan_id');
        });
    }
};
