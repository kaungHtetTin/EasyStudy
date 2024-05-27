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
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('course_id');
            $table->integer('payment_method_id');
            $table->integer('amount')->default(0)->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('course_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::table('payment_histories',function(Blueprint $table){
            $table->dropIndex(['user_id']);
            $table->dropIndex(['course_id']);

            $table->dropForeign(['user_id']);
            $table->dropForeign(['course_id']);
        });
        Schema::dropIfExists('payment_histories');
    }
};
