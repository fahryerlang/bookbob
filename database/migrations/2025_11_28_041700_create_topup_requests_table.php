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
        Schema::create('topup_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('method', ['request', 'transfer', 'gateway']); // request=manual, transfer=bukti, gateway=auto
            $table->decimal('amount', 15, 2);
            $table->enum('status', ['pending', 'approved', 'rejected', 'expired'])->default('pending');
            $table->string('proof_image')->nullable(); // bukti transfer
            $table->foreignId('bank_account_id')->nullable()->constrained()->onDelete('set null');
            $table->string('payment_gateway')->nullable(); // midtrans, xendit, dll
            $table->string('payment_id')->nullable(); // ID dari payment gateway
            $table->text('notes')->nullable(); // catatan dari user
            $table->text('admin_notes')->nullable(); // catatan dari admin
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topup_requests');
    }
};
