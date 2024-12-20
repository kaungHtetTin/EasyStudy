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
        Schema::create('user_privacy_references', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('privacy_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('enable');
            $table->timestamps();

            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('privacy_id')->references('id')->on('privacies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_privacy_references',function(Blueprint $table){
            $table->dropIndex(['user_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['privacy_id']);
        });

        Schema::dropIfExists('user_privacy_references');
    }
};
