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
        Schema::create('learning_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('lesson_id');
            $table->integer('frequent')->default(1)->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('lesson_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('lesson_id')->references('id')->on('lessons')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('learning_histories',function(Blueprint $table){
            $table->dropIndex(['user_id']);
            $table->dropIndex(['lesson_id']);
            
            $table->dropForeign(['user_id']);
            $table->dropForeign(['lesson_id']);
        });
        Schema::dropIfExists('learning_histories');
    }
};
