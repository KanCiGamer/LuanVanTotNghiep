<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reserved_seats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('showtime_id');
            $table->unsignedBigInteger('seat_id');
            $table->timestamp('reserved_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('expires_at');

            $table->foreign('showtime_id')->references('showtime_id')->on('show_times')->onDelete('cascade');
            $table->foreign('seat_id')->references('seat_id')->on('seats')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserved_seats');
    }
};
