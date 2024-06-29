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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('instructor_id');
            $table->unsignedBigInteger('payment_method_type_id')->nullable();
            $table->string('method')->nullable(); // this may be phone no or banck account no
            $table->timestamps();

            $table->foreign('instructor_id')->references('id')->on('instructors')->onDelete('cascade');
            $table->foreign('payment_method_type_id')->references('id')->on('payment_method_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_methods',function(Blueprint $table){
            $table->dropForeign(['instructor_id']);
            $table->dropForeign(['payment_method_type_id']);
        });
        Schema::dropIfExists('payment_methods');
    }
};
