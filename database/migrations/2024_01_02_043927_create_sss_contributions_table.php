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
        Schema::create('sss_contributions', function (Blueprint $table) {
            $table->id('scid');
            $table->string('min_amount');
            $table->string('max_amount');
            $table->string('excess');
            $table->string('percent');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sss_contributions');
    }
};
