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
        Schema::table('sections', function (Blueprint $table) {
            $table->dropForeign(['course_program_id']); // drop the FK constraint first
            $table->dropColumn('course_program_id');    // then drop the column
        });
        
    }
    
    public function down()
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->unsignedBigInteger('course_program_id');
            $table->foreign('course_program_id')->references('id')->on('course_program')->onDelete('cascade');
        });
    }
    
};