<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('doctors', 'specialty_id')) {
            DB::statement('
                INSERT INTO doctor_specialty (doctor_id, specialty_id, created_at, updated_at)
                SELECT id, specialty_id, created_at, updated_at
                FROM doctors
                WHERE specialty_id IS NOT NULL
                ON DUPLICATE KEY UPDATE doctor_specialty.updated_at = NOW()
            ');

            Schema::table('doctors', function (Blueprint $table) {
                $table->dropForeign(['specialty_id']);
                $table->dropColumn('specialty_id');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('doctors', 'specialty_id')) {
            Schema::table('doctors', function (Blueprint $table) {
                $table->unsignedBigInteger('specialty_id')->nullable()->after('phone');
                $table->foreign('specialty_id')->references('id')->on('specialties')->onDelete('set null');
            });

            DB::statement('
                UPDATE doctors
                SET specialty_id = (
                    SELECT specialty_id FROM doctor_specialty
                    WHERE doctor_specialty.doctor_id = doctors.id
                    LIMIT 1
                )
                WHERE id IN (
                    SELECT DISTINCT doctor_id FROM doctor_specialty
                )
            ');

            DB::statement('DELETE FROM doctor_specialty');
        }
    }
};
