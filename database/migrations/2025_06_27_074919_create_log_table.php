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
        Schema::create('log', function (Blueprint $table) {
            // Primary key
            $table->id();
            // Columns
            $table->string('username', 100);
            $table->unsignedBigInteger('software_id')->nullable();
            $table->string('hardware_ip',25)->nullable();
            $table->unsignedBigInteger('rule_id')->nullable(); // e.g., 'create', 'update', 'delete'
            $table->text('message');
            $table->unsignedBigInteger('software_file_id')->nullable();
            $table->string('link_domain', 500)->nullable();
            $table->string('sw_permission_user', 100)->nullable();
            $table->string('hw_permission_user', 100)->nullable();
            $table->string('permission_name', 100)->nullable();
            $table->string('department', 100)->nullable();
            $table->unsignedBigInteger('role_id',)->nullable();
            $table->boolean('is_delete')->default(false);
            // Foreign keys
            $table->foreign('software_id')->references('id')->on('software')->onUpdate('cascade');
            $table->foreign('hardware_ip')->references('ip')->on('hardware')->onUpdate('cascade');
            $table->foreign('username')->references('username')->on('users')->onUpdate('cascade');
            $table->foreign('rule_id')->references('id')->on('rules')->onUpdate('cascade');
            $table->foreign('software_file_id')->references('id')->on('software_file')->onUpdate('cascade');
            $table->foreign('sw_permission_user')->references('user_name')->on('software_permissions')->onUpdate('cascade');
            $table->foreign('hw_permission_user')->references('user_name')->on('hardware_permissions')->onUpdate('cascade');
            $table->foreign('permission_name')->references('permissions_name')->on('permissions')->onUpdate('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onUpdate('cascade');
            $table->foreign('department')->references('name')->on('departments')->onUpdate('cascade');
            $table->foreign('link_domain')->references('link')->on('domain')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log');
    }
};
