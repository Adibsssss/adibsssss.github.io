<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('courses', function (Blueprint $table) {
        $table->id(); 
        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        // New attributes
        $table->string('code')->unique();
        $table->string('subject_title');
        $table->integer('units_lab')->default(0);
        $table->integer('units_lecture')->default(0);
        $table->float('credit')->default(0);

        $table->text('description')->nullable(); 
        $table->timestamps(); 
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};