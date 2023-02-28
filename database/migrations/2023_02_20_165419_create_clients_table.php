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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email') ->unique();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('role')->default('1');
            $table->foreign('role')->references('id')->on('roles');
            $table->boolean('active')->default(false);
            $table->integer('activation_code')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
