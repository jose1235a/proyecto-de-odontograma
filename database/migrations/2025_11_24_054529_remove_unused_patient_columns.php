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
            if (Schema::hasColumn('patients', 'consultation_reason')) {
                $table->dropColumn('consultation_reason');
            }
            if (Schema::hasColumn('patients', 'diagnosis')) {
                $table->dropColumn('diagnosis');
            }
            if (Schema::hasColumn('patients', 'referred_by')) {
                $table->dropColumn('referred_by');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->text('consultation_reason')->nullable()->after('pregnant_description');
            $table->text('diagnosis')->nullable()->after('consultation_reason');
            $table->string('referred_by')->nullable()->after('diagnosis');
        });
    }
};
