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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('id_1c')->nullable();
            $table->string('article')->nullable();
            $table->smallInteger('measure');
            $table->string('name');
            $table->string('barcode')->nullable();
            $table->float('remainder')->nullable();
            $table->boolean('enabled')->default(1);
            $table->string('presale_id')->nullable();
            $table->float('discount')->default(0);
            $table->boolean('hit')->default(0);
            $table->boolean('new')->default(0);
            $table->boolean('action')->default(0);
            $table->boolean('discount_5')->default(0);
            $table->boolean('discount_10')->default(0);
            $table->boolean('discount_15')->default(0);
            $table->boolean('discount_20')->default(0);

            $table->bigInteger('rating')->nullable();
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
        Schema::dropIfExists('products');
    }
};
