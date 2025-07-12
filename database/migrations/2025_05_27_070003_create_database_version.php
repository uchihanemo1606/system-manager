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
        Schema::create('database_version', function (Blueprint $table) {
            $table->id();
            $table->string('dbname',100);
            $table->string('version',100);
            $table->string('version_description')->nullable();
            $table->string('created_by',100);
            $table->string('decription')->nullable();
            $table->boolean('is_delete')->default(true);

            $table->foreign('created_by')->references('username')->on('users')->onUpdate('cascade');
            $table->foreign('dbname')->references('dbname')->on('database')->onUpdate('cascade');
            
            $table->unique(['dbname', 'version'], 'database_version_unique');
            $table->timestamps();

            $table->index('version');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('database_version');
    }
};
