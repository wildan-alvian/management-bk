<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::create('lanjutans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('misconduct_id')->constrained('student_misconducts')->onDelete('cascade');
        $table->text('note')->nullable();
        $table->string('file')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lanjutans');
    }
};
