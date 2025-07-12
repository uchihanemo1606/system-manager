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
        Schema::create('database', function (Blueprint $table) {
            $table->id();
            $table->string('dbname')->unique();
            $table->string('created_by',100);
            $table->string('decription')->nullable();
            $table->boolean('is_delete')->default(true);

            $table->foreign('created_by')->references('username')->on('users')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('database');
    }
};
