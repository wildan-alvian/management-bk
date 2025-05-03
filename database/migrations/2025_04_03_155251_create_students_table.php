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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nisn')->unique();
            $table->string('nama_lengkap');
            $table->string('kelas');
            $table->string('email_siswa')->nullable();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->text('alamat_siswa');
            $table->string('telepon_siswa')->nullable();

            // Data Wali
            $table->string('hubungan_wali');
            $table->string('nama_wali');
            $table->string('telepon_wali')->nullable();
            $table->string('email_wali')->nullable();
            $table->text('alamat_wali');

            // Relasi ke tabel lain (kalau mau)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('student_parent_id')->nullable()->constrained('student_parents')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
