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
        Schema::create('software_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('create_by', 100);
            $table->string('user_name',100);
            $table->string('permissions_name', 100);
            $table->unsignedBigInteger('software_id');
            $table->timestamp('assigned_at');
            $table->foreign('create_by')->references('username')->on('users')->onUpdate('cascade');
            $table->foreign('user_name')->references('username')->on('users')->onUpdate('cascade');
            $table->foreign('software_id')->references('id')->on('software')->onUpdate('cascade');
            $table->timestamps();
        });
    }  

    /** 
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('software_permissions');
    }
};

//sửa tên bảng lại => bỏ user
// bảng phụ chỗ domain và hardware
// rule nối cả software và hardware
//hardwware rule + url => string
