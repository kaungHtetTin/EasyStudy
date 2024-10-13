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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notification_type_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('passive_user_id');
            $table->text('body');
            $table->text('payload');
            $table->boolean('seen')->default(false);
            $table->timestamps();

            $table->index('passive_user_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('passive_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('notification_type_id')->references('id')->on('notification_types')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications',function(Blueprint $table){
            $table->dropIndex(['passive_user_id']);

            $table->dropForeign(['user_id']);
            $table->dropForeign(['passive_user_id']);
            $table->dropForeign(['notification_type_id']);
        });
        Schema::dropIfExists('notifications');
    }
};
