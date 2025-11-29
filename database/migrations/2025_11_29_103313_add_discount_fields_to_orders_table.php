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
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('subtotal', 15, 2)->after('total_amount')->default(0);
            $table->decimal('promo_discount', 15, 2)->after('subtotal')->default(0);
            $table->decimal('coupon_discount', 15, 2)->after('promo_discount')->default(0);
            $table->foreignId('coupon_id')->nullable()->after('coupon_discount')->constrained()->nullOnDelete();
            $table->string('coupon_code')->nullable()->after('coupon_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['coupon_id']);
            $table->dropColumn(['subtotal', 'promo_discount', 'coupon_discount', 'coupon_id', 'coupon_code']);
        });
    }
};
