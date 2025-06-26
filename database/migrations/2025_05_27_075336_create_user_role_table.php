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
        Schema::create('user_role', function (Blueprint $table) {
            $table->id();
            $table->string('username', 100);
            $table->string('role_name', 100);
            $table->timestamp('assigned_at');
            $table->foreign('username')->references('username')->on('users')->onUpdate('cascade');
            $table->foreign('role_name')->references('role_name')->on('roles')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_role');
    }
};
