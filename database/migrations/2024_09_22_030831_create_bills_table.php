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
        Schema::create('bills', function (Blueprint $table) {
            
            $table->id();
            $table->unsignedBigInteger('instructor_id');
            $table->integer('amount')->nullable();
            $table->string('screenshot_url')->nullable();  
            $table->unsignedBigInteger('history_from')->nullable();
            $table->unsignedBigInteger('history_to')->nullable();
            $table->boolean('verified')->default(false)->nullable();
            
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
        Schema::dropIfExists('bills');
    }
};
