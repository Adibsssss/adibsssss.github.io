<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string(column: 'name');
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('max_students');
            $table->string('load_type')->default('regular');
            $table->timestamps();

            $table->unique(['program_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};