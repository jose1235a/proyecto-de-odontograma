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
        Schema::create('treatment_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('odontogram_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id');
            $table->integer('tooth_number');
            $table->string('surface')->nullable(); // top, right, bottom, left, center
            $table->string('treatment_type'); // treatment_X or legacy conditions
            $table->string('action'); // applied, cleared
            $table->json('treatment_data')->nullable(); // additional data about the treatment
            $table->timestamp('treatment_date');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('odontogram_id')->references('id')->on('odontograms')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');

            $table->index(['odontogram_id', 'tooth_number']);
            $table->index(['patient_id', 'treatment_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatment_history');
    }
};