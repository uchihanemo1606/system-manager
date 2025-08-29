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
        Schema::create('rules', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('file_url',250);
            $table->unsignedBigInteger('category_rule_id');
            $table->string('username', 100);
            $table->string('description',100);
            $table->boolean('is_delete')->default(false);
            $table->dateTime('date_release');
            $table->foreign('category_rule_id')->references('id')->on('category_rule')->onUpdate('cascade');
            $table->foreign('username')->references('username')->on('users')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rules');
    }
};
