<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            // Add fields for admin reviews if they don't exist
            if (!Schema::hasColumn('reports', 'submitted_by')) {
                $table->unsignedBigInteger('submitted_by')->nullable()->after('photos');
                $table->foreign('submitted_by')->references('id')->on('users')->onDelete('set null');
            }
            
            if (!Schema::hasColumn('reports', 'student_name')) {
                $table->string('student_name')->nullable()->after('submitted_by');
            }
            
            if (!Schema::hasColumn('reports', 'student_email')) {
                $table->string('student_email')->nullable()->after('student_name');
            }
            
            if (!Schema::hasColumn('reports', 'rating')) {
                $table->unsignedTinyInteger('rating')->nullable()->after('student_email');
            }
            
            if (!Schema::hasColumn('reports', 'admin_id')) {
                $table->unsignedBigInteger('admin_id')->nullable()->after('rating');
                $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            // Drop foreign keys first
            if (Schema::hasColumn('reports', 'submitted_by')) {
                $table->dropForeign(['submitted_by']);
                $table->dropColumn('submitted_by');
            }
            
            if (Schema::hasColumn('reports', 'admin_id')) {
                $table->dropForeign(['admin_id']);
                $table->dropColumn('admin_id');
            }
            
            if (Schema::hasColumn('reports', 'rating')) {
                $table->dropColumn('rating');
            }
            
            if (Schema::hasColumn('reports', 'student_email')) {
                $table->dropColumn('student_email');
            }
            
            if (Schema::hasColumn('reports', 'student_name')) {
                $table->dropColumn('student_name');
            }
        });
    }
};
