<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('odontogram_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('odontogram_id');
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->dateTime('date_procedure')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('odontogram_id')->references('id')->on('odontograms')->cascadeOnDelete();
            $table->foreign('doctor_id')->references('id')->on('doctors')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
        });

        Schema::create('odontogram_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('odontogram_history_id');
            $table->unsignedBigInteger('treatment_id')->nullable();
            $table->json('tooth_number_surfaces')->nullable();
            $table->timestamps();

            $table->foreign('odontogram_history_id')->references('id')->on('odontogram_histories')->cascadeOnDelete();
            $table->foreign('treatment_id')->references('id')->on('treatments')->nullOnDelete();
        });

        if (Schema::hasColumn('odontograms', 'doctor_id')) {
            Schema::table('odontograms', function (Blueprint $table) {
                $table->dropForeign(['doctor_id']);
                $table->dropForeign(['created_by']);
                $table->dropForeign(['deleted_by']);
            });

            $odontograms = DB::table('odontograms')->select([
                'id',
                'doctor_id',
                'title',
                'description',
                'odontogram_data',
                'created_at',
                'created_by',
            ])->get();

            foreach ($odontograms as $odontogram) {
                $historyId = DB::table('odontogram_histories')->insertGetId([
                    'odontogram_id' => $odontogram->id,
                    'doctor_id' => $odontogram->doctor_id,
                    'created_by' => $odontogram->created_by,
                    'date_procedure' => $odontogram->created_at,
                    'description' => $odontogram->description ?? $odontogram->title,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $details = json_decode($odontogram->odontogram_data ?? '[]', true);

                if (is_array($details)) {
                    foreach ($details as $detail) {
                        DB::table('odontogram_details')->insert([
                            'odontogram_history_id' => $historyId,
                            'treatment_id' => $this->extractTreatmentId($detail['condition'] ?? null),
                            'tooth_number_surfaces' => json_encode($detail),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            Schema::table('odontograms', function (Blueprint $table) {
                $table->dropColumn(['doctor_id', 'title', 'description', 'odontogram_data']);
                $table->foreign('created_by')->references('id')->on('users');
                $table->foreign('deleted_by')->references('id')->on('users');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('odontograms', function (Blueprint $table) {
            if (!Schema::hasColumn('odontograms', 'doctor_id')) {
                $table->unsignedBigInteger('doctor_id')->nullable()->after('patient_id');
                $table->string('title')->nullable()->after('doctor_id');
                $table->text('description')->nullable()->after('title');
                $table->json('odontogram_data')->nullable()->after('description');

                $table->foreign('doctor_id')->references('id')->on('doctors')->nullOnDelete();
            }
        });

        Schema::dropIfExists('odontogram_details');
        Schema::dropIfExists('odontogram_histories');
    }

    private function extractTreatmentId(?string $condition): ?int
    {
        if (!is_string($condition)) {
            return null;
        }

        if (Str::startsWith($condition, 'treatment_')) {
            return (int) Str::after($condition, 'treatment_');
        }

        return null;
    }
};
