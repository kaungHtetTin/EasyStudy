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
        Schema::create('reactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('content_id');
            $table->integer('content_type');    // 1 for cost, 2 for post, 3 for comment or review, 
            $table->integer('react'); // 1 for like, 2 for dislike, 

            $table->index('user_id');
            $table->index('content_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reactions',function(Blueprint $table){
            $table->dropIndex(['user_id']);
            $table->dropIndex(['content_id']);
          
            $table->dropForeign(['user_id']);
     
            
        });

        Schema::dropIfExists('reactions');
    }
};
