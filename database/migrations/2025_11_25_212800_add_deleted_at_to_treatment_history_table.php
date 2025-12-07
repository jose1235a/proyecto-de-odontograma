<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add soft deletes to treatment_history if missing.
     */
    public function up(): void
    {
        Schema::table('treatment_history', function (Blueprint $table) {
            if (! Schema::hasColumn('treatment_history', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Rollback soft deletes column.
     */
    public function down(): void
    {
        Schema::table('treatment_history', function (Blueprint $table) {
            if (Schema::hasColumn('treatment_history', 'deleted_at')) {
                $table->dropColumn('deleted_at');
            }
        });
    }
};
