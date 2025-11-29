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
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->enum('type', ['flash_sale', 'seasonal', 'clearance', 'bundle']);
            $table->enum('discount_type', ['percentage', 'fixed']); // persentase atau nominal
            $table->decimal('discount_value', 10, 2); // nilai diskon
            $table->decimal('max_discount', 15, 2)->nullable(); // maksimal potongan (untuk percentage)
            $table->decimal('min_purchase', 15, 2)->default(0); // minimal pembelian
            $table->string('banner_image')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->boolean('is_active')->default(true);
            $table->boolean('apply_to_all_books')->default(false);
            $table->timestamps();
        });

        // Pivot table for promo-book relationship
        Schema::create('promo_book', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promo_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->unique(['promo_id', 'book_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_book');
        Schema::dropIfExists('promos');
    }
};
