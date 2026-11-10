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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('campaigns')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('invoice_number')->unique(); // Contoh: NSK-20261023-0001
            $table->string('donor_name');
            $table->string('donor_email')->nullable();
            $table->boolean('is_anonymous')->default(false); // Jika true, tampil sebagai "Sahabat Niskala"
            $table->decimal('amount', 15, 2);
            $table->text('message')->nullable(); // Doa / pesan dukungan donatur
            $table->string('payment_method', 50)->default('QRIS');
            $table->string('status', 20)->default('verified'); // pending, verified, rejected
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};