<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Create programs table
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->integer('year_level')->nullable();  
            $table->string('semester')->nullable();    
            $table->timestamps();
        });

        Schema::create('course_program', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['program_id', 'course_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_program');
        Schema::dropIfExists('programs');
    }
};