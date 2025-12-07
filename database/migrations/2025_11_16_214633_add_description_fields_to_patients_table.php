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
        Schema::table('patients', function (Blueprint $table) {
            $table->text('under_medical_treatment_description')->nullable()->after('under_medical_treatment');
            $table->text('prone_to_bleeding_description')->nullable()->after('prone_to_bleeding');
            $table->text('allergic_to_medication_description')->nullable()->after('allergic_to_medication');
            $table->text('hypertensive_description')->nullable()->after('hypertensive');
            $table->text('diabetic_description')->nullable()->after('diabetic');
            $table->text('pregnant_description')->nullable()->after('pregnant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn([
                'under_medical_treatment_description',
                'prone_to_bleeding_description',
                'allergic_to_medication_description',
                'hypertensive_description',
                'diabetic_description',
                'pregnant_description',
            ]);
        });
    }
};
