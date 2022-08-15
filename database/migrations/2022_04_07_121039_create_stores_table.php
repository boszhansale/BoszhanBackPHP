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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salesrep_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('driver_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('counteragent_id')->nullable()->constrained('counteragents')->cascadeOnDelete();

            $table->string('name');
            $table->string('phone');
            $table->string('bin')->nullable();
            $table->string('id_1c')->nullable();

            $table->foreignId('district_id')->nullable()->constrained('districts')->cascadeOnDelete();

            $table->string('address')->nullable();
            $table->decimal('lat',11,8)->nullable();
            $table->decimal('lng',11,8)->nullable();
            $table->float('discount')->default(0);
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
        Schema::dropIfExists('stores');
    }
};
