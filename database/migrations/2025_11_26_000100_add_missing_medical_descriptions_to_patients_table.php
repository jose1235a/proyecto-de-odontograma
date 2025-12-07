<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add missing medical description columns to patients.
     */
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $columns = [
                'under_medical_treatment_description',
                'prone_to_bleeding_description',
                'allergic_to_medication_description',
                'hypertensive_description',
                'diabetic_description',
                'pregnant_description',
            ];

            foreach ($columns as $column) {
                if (! Schema::hasColumn('patients', $column)) {
                    $table->text($column)->nullable()->after('pregnant');
                }
            }
        });
    }

    /**
     * Drop added columns on rollback.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $columns = [
                'under_medical_treatment_description',
                'prone_to_bleeding_description',
                'allergic_to_medication_description',
                'hypertensive_description',
                'diabetic_description',
                'pregnant_description',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('patients', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
