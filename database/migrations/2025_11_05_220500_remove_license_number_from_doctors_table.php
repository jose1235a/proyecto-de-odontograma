<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('doctors', 'license_number')) {
            Schema::table('doctors', function (Blueprint $table) {
                $table->dropColumn('license_number');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('doctors', 'license_number')) {
            Schema::table('doctors', function (Blueprint $table) {
                $table->string('license_number', 50)->nullable()->after('specialty_id');
            });
        }
    }
};
