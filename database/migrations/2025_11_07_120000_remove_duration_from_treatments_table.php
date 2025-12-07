<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('treatments', 'duration')) {
            Schema::table('treatments', function (Blueprint $table) {
                $table->dropColumn('duration');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('treatments', 'duration')) {
            Schema::table('treatments', function (Blueprint $table) {
                $table->integer('duration')->default(30)->after('cost');
            });
        }
    }
};
