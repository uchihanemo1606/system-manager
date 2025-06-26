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
        Schema::create('software_file', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('software_id');
            $table->string('username',100);
            $table->string('file_name', 200);
            $table->string('file_path', 255);
            $table->text('description')->nullable();
            $table->foreign('username')->references('username')->on('users')->onUpdate('cascade');
            $table->foreign('software_id')->references('id')->on('software')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('software_file');
    }
};
