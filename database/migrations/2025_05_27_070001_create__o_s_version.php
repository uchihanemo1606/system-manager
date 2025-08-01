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
        Schema::create('os_version', function (Blueprint $table) {
            $table->id();
            $table->string('os_name',100);
            $table->string('version',100);
            $table->string('created_by',100)->nullable();
            $table->string('description')->nullable();
            $table->boolean('is_delete')->default(true);

            $table->foreign('created_by')->references('username')->on('users')->onUpdate('cascade');
            $table->foreign('os_name')->references('name')->on('os')->onUpdate('cascade');

            $table->unique(['os_name', 'version'], 'os_version_unique'); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('os_version');
    }
};
