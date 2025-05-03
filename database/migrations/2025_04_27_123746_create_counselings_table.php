<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCounselingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('counselings', function (Blueprint $table) {
            $table->id();
            $table->timestamp('scheduled_at')->nullable(); 
            $table->string('submitted_by');
            $table->enum('counseling_type', ['siswa', 'wali_murid']); 
            $table->string('title'); 
            $table->enum('status', ['new', 'on_progress', 'approved', 'rejected', 'canceled'])->default('new'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counselings');
    }
}
