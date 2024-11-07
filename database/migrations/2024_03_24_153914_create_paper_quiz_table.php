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
        Schema::create('paper_quiz', function (Blueprint $table) {
            $table->primary(["paper_id","quiz_id"]);
            $table->foreignId("paper_id")->constrained()->onDelete('cascade');
            $table->foreignId("quiz_id")->constrained()->onDelete('cascade');
            $table->integer("position");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paper_quiz');
    }
};
