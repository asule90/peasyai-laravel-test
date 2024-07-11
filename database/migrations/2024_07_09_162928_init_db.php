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
        Schema::create('random_user', function(Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('gender', 10);
            $table->jsonb('name');
            $table->jsonb('location');
            $table->unsignedInteger('age');
        });
        Schema::create('daily_record', function(Blueprint $table) {
            $table->date('date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedInteger('male_count');
            $table->unsignedInteger('female_count');
            $table->decimal('male_avg_age', 10, 2);
            $table->decimal('female_avg_age', 10, 2);

            $table->primary('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_record');
        Schema::dropIfExists('random_user');
    }
};
