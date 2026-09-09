<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;

return new class extends Migration
{
    public function up(): void
    {
        Artisan::call('laravolt:indonesia:seed');
    }

    public function down(): void
    {
        // Region data is owned by the package and is not removed on rollback.
    }
};
