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
        Schema::create('presensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->dateTime('tanggal_waktu');
            $table->enum('status', ['hadir', 'izin', 'dispensasi']);
            $table->string('lampiran')->nullable(); // untuk file
            $table->text('deskripsi')->nullable(); // untuk izin/dispensasi
            $table->string('foto')->nullable(); // untuk foto hadir
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('presensi');
    }
};
