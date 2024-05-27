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
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('test_id');
            $table->integer('score')->default(0)->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('test_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('test_id')->references('id')->on('tests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test_results',function(Blueprint $table){
            $table->dropIndex(['user_id']);
            $table->dropIndex(['test_id']);

            $table->dropForeign(['user_id']);
            $table->dropForeign(['test_id']);
        });
        Schema::dropIfExists('test_results');
    }
};
