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
        Schema::create('hardware', function (Blueprint $table) {
            $table->string('ip', 25) ->primary();
            $table->string('dbname',100);
            $table->string('dbversion', 100);
            $table->boolean('isVirtualServer')->default(false); 
            $table->string('OS', 100);
            $table->string('OSver', 100);
            $table->string('hdd', 50);
            $table->string('ram', 50);
            $table->boolean('is_delete')->default(false);
            $table->text('services');
            $table->boolean('is_active')->default(true);
            $table->string('created_by', 100);


            $table->foreign('created_by')->references('username')->on('users')->onUpdate('cascade');

            $table->foreign('dbname')->references('dbname')->on('database')->onUpdate('cascade');
            $table->foreign(['dbname', 'dbversion'])->references(['dbname', 'version'])->on('database_version')->onUpdate('cascade');
            $table->foreign('OS')->references('name')->on('os')->onUpdate('cascade');
            $table->foreign(['OS', 'OSver'])->references(['os_name', 'version'])->on('os_version')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hardware');
    }
};