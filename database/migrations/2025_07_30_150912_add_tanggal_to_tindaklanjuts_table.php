<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTanggalToTindaklanjutsTable extends Migration
{
    public function up()
    {
        Schema::table('tindaklanjuts', function (Blueprint $table) {
            $table->date('tanggal')->nullable()->after('description');
        });
    }

    public function down()
    {
        Schema::table('tindaklanjuts', function (Blueprint $table) {
            $table->dropColumn('tanggal');
        });
    }
}
