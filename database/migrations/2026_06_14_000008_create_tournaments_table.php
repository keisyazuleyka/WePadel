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
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('max_teams');
            $table->decimal('registration_fee', 12, 2);
            $table->string('status')->default('upcoming'); // upcoming, ongoing, completed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};
