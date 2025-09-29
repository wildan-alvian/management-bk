<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Ubah kolom status, tambahkan 'terlambat'
        DB::statement("ALTER TABLE presensi 
            MODIFY status ENUM('hadir','izin','dispensasi','terlambat') NOT NULL");
    }

    public function down(): void
    {
        // Rollback: hapus 'terlambat'
        DB::statement("ALTER TABLE presensi 
            MODIFY status ENUM('hadir','izin','dispensasi') NOT NULL");
    }
};

