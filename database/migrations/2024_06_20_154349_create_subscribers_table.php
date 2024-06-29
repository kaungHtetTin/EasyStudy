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
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('instructor_id');

            $table->index('user_id');
            $table->index('instructor_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('instructor_id')->references('id')->on('instructors')->onDelete('cascade');

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
        Schema::table('subscribers',function(Blueprint $table){
            $table->dropIndex(['user_id']);
            $table->dropIndex(['instructor_id']);
          
            $table->dropForeign(['user_id']);
            $table->dropForeign(['instructor_id']);
            
        });

        Schema::dropIfExists('subscribers');
    }
};
