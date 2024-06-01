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
        Schema::create('mail_boxes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // this is sender id
            $table->unsignedBigInteger('receiver_id');
            $table->string('title');
            $table->text('body');
            $table->timestamps();

            $table->index('user_id');
            $table->index('receiver_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
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
            $table->dropIndex(['receiver_id']);
            $table->dropIndex(['user_id']);

            $table->dropForeign(['receiver_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('mail_boxes');
    }
};
