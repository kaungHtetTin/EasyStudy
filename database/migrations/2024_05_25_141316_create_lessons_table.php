<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('lesson_type_id');
            $table->string('title');
            $table->string('mini_title')->nullable();
            $table->string('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('view')->detault(0)->nullable();
            $table->string('link')->nullable();
            $table->string('download_url')->nullable();
            $table->integer('duration')->detault(0)->nullable();
            $table->boolean('downloadable')->detault(false)->nullable();
            $table->timestamps();

            $table->index('course_id');
            $table->index('module_id');

            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
            $table->foreign('lesson_type_id')->references('id')->on('lesson_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lessons',function(Blueprint $table){
            $table->dropIndex(['course_id']);
            $table->dropIndex(['module_id']);

            $table->dropForeign(['course_id']);
            $table->dropForeign(['module_id']);
            $table->dropForeign(['lesson_type_id']);
        });
        Schema::dropIfExists('lessons');
    }
};
