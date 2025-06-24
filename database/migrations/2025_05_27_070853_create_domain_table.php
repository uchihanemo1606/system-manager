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
        Schema::create('domain', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('software_id');
            $table->text('name');
            $table->string('link', 500)->unique();
            $table->string('createBy',100);
            $table->foreign('software_id')->references('id')->on('software')->onUpdate('cascade');
            $table->foreign('createBy')->references('username')->on('users')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domain');
    }
};
