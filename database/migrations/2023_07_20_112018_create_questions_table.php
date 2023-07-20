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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->unsignedBigInteger('kind_id');
            $table->tinyInteger('is_paralysis');
            $table->string('image')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('kind_id')->references('id')->on('kind_questions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign(['kind_id']);
        });
        Schema::dropIfExists('questions');
    }
};
