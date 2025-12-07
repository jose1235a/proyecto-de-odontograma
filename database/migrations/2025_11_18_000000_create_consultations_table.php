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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('treatment_id'); // Motivo de la consulta
            $table->unsignedBigInteger('doctor_id'); // Médico dental
            $table->date('consultation_date');
            $table->time('consultation_time')->nullable();
            $table->decimal('cost', 10, 2)->default(0);
            $table->text('description')->nullable();
            $table->decimal('fever', 4, 1)->nullable(); // Fiebre en grados Celsius
            $table->string('blood_pressure')->nullable(); // Presión sanguínea ej: "120/80"
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->text('deleted_description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('treatment_id')->references('id')->on('treatments');
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('deleted_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};