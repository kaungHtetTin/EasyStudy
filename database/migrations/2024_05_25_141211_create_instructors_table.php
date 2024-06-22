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
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('student_enroll')->default(0)->nullable();
            $table->integer('subscriber')->default(0);
            $table->integer('total_course')->default(0);
            $table->boolean('is_active')->default(true);
            $table->datetime('last_billing_date')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviews',function(Blueprint $table){
            $table->dropIndex(['user_id']);
            
            $table->dropForeign(['user_id']);
            
        });
        Schema::dropIfExists('instructors');
    }
};
