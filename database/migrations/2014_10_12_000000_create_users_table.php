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
            $table->string('phone')->nullable();
            $table->string('login')->unique();
            $table->string('password');
            $table->string('id_1c')->nullable();
            $table->string('device_token')->nullable();
            $table->boolean('winning_access')->default(0);
            $table->boolean('payout_access')->default(0);
            $table->smallInteger('status')->default(1);
            $table->decimal('lat',[11,8])->nullable();
            $table->decimal('lng',[11,8])->nullable();
            $table->rememberToken();
            $table->softDeletes();
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
