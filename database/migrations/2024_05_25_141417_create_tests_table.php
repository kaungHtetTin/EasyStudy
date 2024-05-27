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
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->string('title')->nullable();
            $table->integer('allowed_time')->default(0)->nullable();
            $table->integer('total_question')->default(0)->nullable();
            $table->timestamps();

            $table->index('course_id');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tests',function(Blueprint $table){
            $table->dropIndex(['course_id']);
            $table->dropForeign(['course_id']);
        });
        Schema::dropIfExists('tests');
    }
};
