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
        Schema::table('counselings', function (Blueprint $table) {
            $table->unsignedBigInteger('submitted_by_id')->nullable();

            $table->foreign('submitted_by_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('counselings', function (Blueprint $table) {
            $table->dropForeign(['submitted_by_id']);

            $table->dropColumn('submitted_by_id');
        });
    }
};
