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
        Schema::table('appointments', function (Blueprint $table) {
            if (!Schema::hasColumn('appointments', 'disease')) {
                $table->string('disease')->nullable()->after('status');
            }

            if (!Schema::hasColumn('appointments', 'cost')) {
                $table->decimal('cost', 10, 2)->default(0)->after('disease');
            }

            if (!Schema::hasColumn('appointments', 'paid')) {
                $table->decimal('paid', 10, 2)->default(0)->after('cost');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            if (Schema::hasColumn('appointments', 'disease')) {
                $table->dropColumn('disease');
            }

            if (Schema::hasColumn('appointments', 'cost')) {
                $table->dropColumn('cost');
            }

            if (Schema::hasColumn('appointments', 'paid')) {
                $table->dropColumn('paid');
            }
        });
    }
};