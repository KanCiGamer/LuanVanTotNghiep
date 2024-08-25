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
        Schema::create('discount_uses', function (Blueprint $table) {
            $table->char('user_id', 10);
            $table->foreign('user_id')->references('user_id')->on('users');

            $table->unsignedBigInteger('discount_code_id');
            $table->foreign('discount_code_id')->references('id')->on('discount_codes');

            $table->char('invoice_id', 10);
            $table->foreign('invoice_id')->references('invoice_id')->on('invoices');
            $table->timestamps();

            // Khóa chính (composite key)
            $table->primary(['user_id', 'discount_code_id', 'invoice_id']);

            //$table->foreign('role_id')->references('role_id')->on('user_roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_uses');
    }
};
