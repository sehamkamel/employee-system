<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            if (!Schema::hasColumn('employees', 'department_id')) {
                $table->unsignedBigInteger('department_id')->after('phone');
                $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            }

            if (!Schema::hasColumn('employees', 'job_title_id')) {
                $table->unsignedBigInteger('job_title_id')->nullable()->after('department_id');
                $table->foreign('job_title_id')->references('id')->on('job_titles')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            if (Schema::hasColumn('employees', 'job_title_id')) {
                $table->dropForeign(['job_title_id']);
                $table->dropColumn('job_title_id');
            }

            if (Schema::hasColumn('employees', 'department_id')) {
                $table->dropForeign(['department_id']);
                $table->dropColumn('department_id');
            }
        });
    }
};
