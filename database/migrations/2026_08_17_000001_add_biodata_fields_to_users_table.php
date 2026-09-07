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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'full_name')) {
                $table->string('full_name')->nullable();
            }
            if (!Schema::hasColumn('users', 'place_of_birth')) {
                $table->string('place_of_birth')->nullable();
            }
            if (!Schema::hasColumn('users', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable();
            }
            if (!Schema::hasColumn('users', 'photo_3x4')) {
                $table->string('photo_3x4')->nullable();
            }
            if (!Schema::hasColumn('users', 'school_origin')) {
                $table->string('school_origin')->nullable();
            }
            if (!Schema::hasColumn('users', 'gender')) {
                $table->string('gender')->nullable();
            }
            if (!Schema::hasColumn('users', 'agama')) {
                $table->string('agama')->nullable();
            }
            if (!Schema::hasColumn('users', 'kewarganegaraan')) {
                $table->string('kewarganegaraan')->nullable();
            }
            if (!Schema::hasColumn('users', 'status_pernikahan')) {
                $table->string('status_pernikahan')->nullable();
            }
            if (!Schema::hasColumn('users', 'provinsi')) {
                $table->string('provinsi')->nullable();
            }
            if (!Schema::hasColumn('users', 'kabupaten_kota')) {
                $table->string('kabupaten_kota')->nullable();
            }
            if (!Schema::hasColumn('users', 'jalan')) {
                $table->string('jalan')->nullable();
            }
            if (!Schema::hasColumn('users', 'dusun')) {
                $table->string('dusun')->nullable();
            }
            if (!Schema::hasColumn('users', 'kecamatan')) {
                $table->string('kecamatan')->nullable();
            }
            if (!Schema::hasColumn('users', 'kelurahan_desa')) {
                $table->string('kelurahan_desa')->nullable();
            }
            if (!Schema::hasColumn('users', 'rt')) {
                $table->string('rt')->nullable();
            }
            if (!Schema::hasColumn('users', 'rw')) {
                $table->string('rw')->nullable();
            }
            if (!Schema::hasColumn('users', 'kode_pos')) {
                $table->string('kode_pos')->nullable();
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable();
            }
            if (!Schema::hasColumn('users', 'whatsapp_number')) {
                $table->string('whatsapp_number')->nullable();
            }
            if (!Schema::hasColumn('users', 'telegram_number')) {
                $table->string('telegram_number')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = [
                'full_name',
                'place_of_birth',
                'date_of_birth',
                'photo_3x4',
                'school_origin',
                'gender',
                'agama',
                'kewarganegaraan',
                'status_pernikahan',
                'provinsi',
                'kabupaten_kota',
                'jalan',
                'dusun',
                'kecamatan',
                'kelurahan_desa',
                'rt',
                'rw',
                'kode_pos',
                'address',
                'whatsapp_number',
                'telegram_number',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
