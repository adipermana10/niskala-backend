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
        Schema::table('disasters', function (Blueprint $table) {
            if (!Schema::hasColumn('disasters', 'latitude')) {
                $table->decimal('latitude', 10, 7)->default(-7.5407170)->after('location');
            }
            if (!Schema::hasColumn('disasters', 'longitude')) {
                $table->decimal('longitude', 10, 7)->default(110.4457240)->after('latitude');
            }
            if (!Schema::hasColumn('disasters', 'impact_radius_km')) {
                $table->decimal('impact_radius_km', 6, 2)->default(5.00)->after('longitude');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('disasters', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'impact_radius_km']);
        });
    }
};