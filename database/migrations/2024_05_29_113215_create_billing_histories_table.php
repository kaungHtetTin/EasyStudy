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
        Schema::create('billing_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('instructor_id');
            $table->integer('amount');
            $table->boolean('verified')->default(false);
            $table->timestamps();

            $table->index('instructor_id');
           
            $table->foreign('instructor_id')->references('id')->on('instructors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('billing_histories',function(Blueprint $table){
            $table->dropIndex(['instructor_id']);
            $table->dropForeign(['instructor_id']);
            
        });
        Schema::dropIfExists('billing_histories');
    }
};
