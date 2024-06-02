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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('instructor_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->unsignedBigInteger('topic_id');
            $table->string('title');
            $table->text('description');
            $table->integer('fee')->default(0)->nullable();
            $table->string('cover_url')->nullable();
            $table->float('rating')->default(0)->nullable();
            $table->integer('total_rating')->detault(0)->nullable();
            $table->integer('enroll')->detault(0)->nullable();
            $table->string('language')->nullable();
            $table->integer('total_lecture')->detault(0)->nullable();
            $table->integer('duration')->detault(0)->nullable();
            $table->string('community_link')->nullable();
            $table->json('payment_method_id')->nullable();
            $table->boolean('certificate')->default(false)->nullable();
            $table->integer('visit')->default(0)->nullable();
            $table->timestamps();

            $table->index('title');
            $table->index('rating');
            $table->index('category_id');
            $table->index('sub_category_id');
            $table->index('topic_id');
            $table->index('instructor_id');

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('instructor_id')->references('id')->on('instructors')->onDelete('cascade');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade');
            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropIndex(['title']);
            $table->dropIndex(['rating']);
            $table->dropIndex(['category_id']);
            $table->dropIndex(['instructor_id']);
            $table->dropIndex(['sub_category_id']);
            $table->dropIndex(['topic_id']);

            $table->dropForeign(['category_id']);
            $table->dropForeign(['instructor_id']);
            $table->dropForeign(['sub_category_id']);
            $table->dropForeign(['topic_id']);
        });
        Schema::dropIfExists('courses');
    }
};
