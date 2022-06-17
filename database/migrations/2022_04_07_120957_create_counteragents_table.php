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
        Schema::create('counteragents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('id_1c')->nullable();
            $table->string('bin')->nullable();
            $table->foreignId('payment_type_id')->constrained('payment_types')->cascadeOnDelete();
            $table->foreignId('price_type_id')->constrained('price_types')->cascadeOnDelete();
            $table->float('discount')->default(0);
            $table->boolean('enabled')->default(1);
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
        Schema::dropIfExists('counteragents');
    }
};
