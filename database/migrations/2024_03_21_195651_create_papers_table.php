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
        Schema::create('papers', function (Blueprint $table) {
            $table->id();
            $table->string("name")->unique()->nullable();
            $table->string("header")->nullable();
            $table->string("header_img")->nullable();
            $table->string("grade")->nullable();
            $table->string("time_allowed")->nullable();
            $table->string("total_mark")->nullable();
            $table->string("info")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('papers');
    }
};
