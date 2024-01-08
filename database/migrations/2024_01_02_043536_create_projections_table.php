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
        Schema::create('projections', function (Blueprint $table) {
            $table->id('pid');
            $table->integer('uid');
            $table->integer('period');
            $table->string('gross_pay');
            $table->string('le_minimis');
            $table->string('pagibig');
            $table->string('sss');
            $table->string('gsis');
            $table->string('philhealth');
            $table->string('non_gov_deductions');
            $table->string('tax');
            $table->string('net_pay');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projections');
    }
};
