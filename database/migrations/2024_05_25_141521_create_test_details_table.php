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
        Schema::create('test_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('test_id');
            $table->string('question')->nullable();
            $table->json('answer')->nullable(); // must be json
            $table->string('correct_answer')->nullable();
            $table->timestamps();

            $table->index('test_id');
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
        Schema::table('test_details',function(Blueprint $table){
            $table->dropIndex(['test_id']);
            $table->dropForeign(['test_id']);
        });
        Schema::dropIfExists('test_details');
    }
};
