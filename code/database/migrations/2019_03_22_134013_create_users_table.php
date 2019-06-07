<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;
use App\User;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('users');
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('full_name');
            $table->string('phone');
            $table->smallInteger('user_level')->default(1); //1->customer 2->manager 3->admin 4->chat_support
            $table->string('image')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('verification_token')->nullable();
            $table->boolean('verified')->default(User::UNVERIFIED);
            $table->rememberToken();
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
}
