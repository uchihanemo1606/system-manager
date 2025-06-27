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
        Schema::create('hardware_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('hardware_ip',25);
            $table->string('permissions_name', 100);
            $table->string('user_name', 100);
            $table->string(('user_createby'),100);
            $table->timestamp('assigned_at');
            $table->foreign('hardware_ip')->references('ip')->on('hardware')->onUpdate('cascade');
            $table->foreign('permissions_name')->references('permissions_name')->on('permissions')->onUpdate('cascade');
            $table->foreign('user_name')->references('username')->on('users')->onUpdate('cascade');
            $table->foreign('user_createby')->references('username')->on('users')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hardware_permissions');
    }
};
