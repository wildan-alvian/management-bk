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
        
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'nama_lengkap',
                'kelas',
                'email_siswa',
                'tempat_lahir',
                'tanggal_lahir',
                'alamat_siswa',
                'telepon_siswa',
                'hubungan_wali',
                'nama_wali',
                'telepon_wali',
                'email_wali',
                'alamat_wali'
            ]);
        });

        Schema::table('students', function (Blueprint $table) {
            $table->string('class');
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->date('birthdate')->nullable();
            $table->string('birthplace')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Restore original columns
            $table->string('nama_lengkap');
            $table->string('kelas');
            $table->string('email_siswa')->nullable();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->text('alamat_siswa');
            $table->string('telepon_siswa')->nullable();
            $table->string('hubungan_wali');
            $table->string('nama_wali');
            $table->string('telepon_wali')->nullable();
            $table->string('email_wali')->nullable();
            $table->text('alamat_wali');

            // Drop new columns
            $table->dropColumn([
                'class',
                'gender',
                'birthdate',
                'birthplace'
            ]);
        });
    }
};
