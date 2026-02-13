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
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(true);
            $table->string('title_ua');
            $table->string('title_en');
            $table->text('description_ua');
            $table->text('description_en');
            $table->string('poster');
            $table->json('screenshots');
            $table->string('trailer');
            $table->dateTime('release_date');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};
