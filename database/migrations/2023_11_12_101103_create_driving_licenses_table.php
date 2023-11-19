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
        Schema::create('driving_licenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('supplier_id');
            $table->string('driving_licenses_code');
            $table->string('driving_licenses_kind');
            $table->timestamp('start_date');
            $table->timestamp('end_date')->nullable();
            $table->string('issued_by');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('driving_licenses', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['supplier_id']);
        });
        Schema::dropIfExists('driving_licenses');
    }
};
