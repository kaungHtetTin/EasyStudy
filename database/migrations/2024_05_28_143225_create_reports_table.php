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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('report_type_id');
            $table->string('body');
            $table->boolean('action_taken')->default(false);
            $table->timestamps();

            $table->index('user_id');
            $table->index('course_id');

            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('report_type_id')->references('id')->on('report_types')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reports',function(Blueprint $table){
            $table->dropIndex(['course_id']);
            $table->dropIndex(['user_id']);

            $table->dropForeign(['course_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['report_type_id']);
        });

        Schema::dropIfExists('reports');
    }
};
