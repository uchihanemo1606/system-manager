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
        Schema::create('users', function (Blueprint $table) {
            $table->string('username', 100)->primary();
            $table->string('password', 500);
            $table->string('fullName', 100)->nullable();
            $table->string('email', 100) ->nullable() ->unique();
            $table->string('avatar', 255)->nullable();
            $table->boolean('hidden')->default(false);
            $table->boolean('is_delete')->default(false);
            $table->string('department', 100)->nullable();
            $table->timestamps();
        });

        
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
    }
};
