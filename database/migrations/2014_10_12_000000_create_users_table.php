<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
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
            $table->string('full_name', 255);
            $table->string('phone_number')->unique();
            $table->timestamp('phone_number_verified_at')->nullable();
            $table->bigInteger("cabang_id");
            $table->string('special_code', 255);
            $table->string('picture_path', 255)->nullable();
            $table->string("address", 255);
            $table->integer('otp')->nullable();
            $table->timestamp('otp_exp')->nullable();
            $table->integer('isActive')->default(0);
            $table->enum('role', ['admin', 'user', 'superadmin'])->default('user');
            $table->string('password');
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
