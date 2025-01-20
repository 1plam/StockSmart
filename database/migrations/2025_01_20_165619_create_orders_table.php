<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->string('status', 20);
            $table->decimal('total_amount', 10, 2);
            $table->text('notes')->nullable();
            $table->string('discount_code', 20)->nullable()->index();
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();

            // Indexes for common queries
            $table->index(['user_id', 'status']);
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
