<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('faskes', function (Blueprint $table) {
            $table->dropColumn('progress');
            $table->text('catatan')->nullable()->after('tim');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faskes', function (Blueprint $table) {
            $table->tinyInteger('progress')->unsigned()->default(0);
            $table->dropColumn('catatan');
        });
    }
};
