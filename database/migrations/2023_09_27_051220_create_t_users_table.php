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
        Schema::create('t_users', function (Blueprint $table) {
            $table->id();
            $table->integer('idno');
            $table->string('name');
            $table->string('name_kana');
            $table->string('position');
            $table->string('email');
            $table->integer('year');
            $table->integer('counter')->default(1);
            $table->integer('already')->default(1);
            $table->integer('pass_fail')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_users');
    }
};
