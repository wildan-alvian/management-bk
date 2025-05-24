<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_achievements', function (Blueprint $table) {
            $table->string('attachment')->nullable()->after('detail');
        });

        Schema::table('student_misconducts', function (Blueprint $table) {
            $table->string('attachment')->nullable()->after('detail');
        });
    }

    public function down(): void
    {
        Schema::table('student_achievements', function (Blueprint $table) {
            $table->dropColumn('attachment');
        });

        Schema::table('student_misconducts', function (Blueprint $table) {
            $table->dropColumn('attachment');
        });
    }
};
