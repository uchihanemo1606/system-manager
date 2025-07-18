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
        Schema::table('departments', function (Blueprint $table) {
            $table->foreign('created_by')->references('username')->on('users')->onUpdate('cascade');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('department')->references('name')->on('departments')->onUpdate('cascade');
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        Schema::table('departments', function (Blueprint $table) {
        // Nếu lỗi vẫn xảy ra, dùng tên key tường minh:
        // $table->dropForeign('departments_created_by_foreign');
        $table->dropForeign(['created_by']);
    });

    Schema::table('users', function (Blueprint $table) {
        // $table->dropForeign('users_department_foreign');
        $table->dropForeign(['department']);
    });

    }
};
