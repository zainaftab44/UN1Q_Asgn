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
        Schema::table('events', function (Blueprint $table) {
            //
            $table->dateTime('until_datetime');
            $table->dropColumn('occurrence');
        });
        // Schema::table('event_occurrences', function (Blueprint $table) {
        //     //to be used in case occurrences are to be updated anew
        //     $table->boolean('dirty')->nullable()->default(false);
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('until_datetime');
            $table->integer('occurrence');
        });
        // Schema::table('event_occurrences', function (Blueprint $table) {
        //     $table->dropColumn('dirty');
        // });
    }
};
