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
        Schema::create('hardware_access_domain', function (Blueprint $table) {
            $table->id();
            $table->string('hardware_ip', 25);
            $table->unsignedBigInteger('domain_id');
            $table->foreign('hardware_ip')->references('ip')->on('hardware')->onUpdate('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hardware_access_domain');
    }
};
