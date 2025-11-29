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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Kode kupon (misal: DISKON10)
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['percentage', 'fixed']); // persentase atau nominal
            $table->decimal('value', 10, 2); // nilai diskon
            $table->decimal('max_discount', 15, 2)->nullable(); // maksimal potongan (untuk percentage)
            $table->decimal('min_purchase', 15, 2)->default(0); // minimal pembelian
            $table->integer('usage_limit')->nullable(); // batas total penggunaan
            $table->integer('usage_limit_per_user')->default(1); // batas per user
            $table->integer('used_count')->default(0); // jumlah terpakai
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_first_purchase_only')->default(false); // khusus pembelian pertama
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
