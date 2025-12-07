<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update existing records with null timestamps
        DB::statement('
            UPDATE doctor_specialty
            SET created_at = NOW(), updated_at = NOW()
            WHERE created_at IS NULL OR updated_at IS NULL
        ');
    }

    public function down(): void
    {
        // No need to revert timestamps
    }
};