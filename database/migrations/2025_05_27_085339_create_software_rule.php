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
        Schema::create('software_rule', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rule_id');
            $table->unsignedBigInteger('software_id');
            $table->dateTime('assigned_at')->useCurrent();
            $table->foreign('software_id')->references('id')->on('software')->onUpdate('cascade');
            $table->foreign('rule_id')->references('id')->on('rules')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('software_rule');
    }
};


//hardware ip đổi thành sofware
