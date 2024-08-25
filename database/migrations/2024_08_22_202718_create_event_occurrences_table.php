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
        Schema::create('event_occurrences', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->foreignId('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->timestamps();
        });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_occurrences');
    }
};
