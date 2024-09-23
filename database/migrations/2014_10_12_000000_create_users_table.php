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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->timestamp('birth_date')->nullable();
            $table->integer('login_time')->default(1);
            $table->timestamp('last_active')->nullable();
            $table->string('fcm_token')->nullable();
            $table->string('image_url')->nullable();
            $table->string('bio')->nullable();
            $table->string('education')->nullable();
            $table->string('gender')->nullable();
            $table->boolean('disable')->default(false)->nullable();
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
        Schema::dropIfExists('users');
    }
};
