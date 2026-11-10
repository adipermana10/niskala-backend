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
        Schema::create('disasters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('location'); // Contoh: "Kab. Lumajang, Jawa Timur"
            $table->dateTime('occurred_at');
            $table->string('status', 30)->default('tanggap_darurat'); // siaga, tanggap_darurat, pemulihan, selesai
            $table->text('summary'); // Ringkasan cepat dampak & kebutuhan mendesak
            $table->longText('content'); // Kronologi & detail laporan bencana
            $table->string('thumbnail')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disasters');
    }
};