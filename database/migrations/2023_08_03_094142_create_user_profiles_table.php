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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->char('avatarId');
            $table->foreign('avatarId')->references('id')->on('avatars');
            $table->string('username')->unique();
            $table->string('name')->nullable();
            $table->string('alamat')->nullable();
            $table->string('tempatLahir')->nullable();
            $table->date('tanggalLahir')->nullable();
            $table->string('pendidikanTerakhir')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->integer('penghasilan')->nullable();
            $table->string('noHp')->nullable();
            $table->string('role')->nullable();
            $table->string('email')->nullable();
            $table->string('bio')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
