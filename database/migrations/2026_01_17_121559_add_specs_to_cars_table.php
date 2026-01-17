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
        Schema::table('cars', function (Blueprint $table) {
            $table->enum('transmission', ['manual', 'automatic'])->default('manual')->after('price_per_day');
            $table->enum('fuel_type', ['petrol', 'diesel', 'electric', 'hybrid'])->default('petrol')->after('transmission');
            $table->integer('seats')->default(5)->after('fuel_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn(['transmission', 'fuel_type', 'seats']);
        });
    }
};
