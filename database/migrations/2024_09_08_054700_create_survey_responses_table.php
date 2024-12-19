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
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();
            $table->string('Office')->default(0)->nullable();
            $table->string('Service')->default(0)->nullable();
            $table->string('SQD_0')->default(0)->nullable();
            $table->string('SQD_1')->default(0)->nullable();
            $table->string('SQD_2')->default(0)->nullable();
            $table->string('SQD_3')->default(0)->nullable();
            $table->string('SQD_4')->default(0)->nullable();
            $table->string('SQD_5')->default(0)->nullable();
            $table->string('SQD_6')->default(0)->nullable();
            $table->string('SQD_7')->default(0)->nullable();
            $table->text('Feedback')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_responses');
    }
};
