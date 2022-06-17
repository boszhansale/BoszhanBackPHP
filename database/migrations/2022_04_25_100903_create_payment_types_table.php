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
        Schema::create('payment_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });



        \App\Models\PaymentType::insert([
            [
                'name' => 'Наличный',
            ],
            [
                'name' => 'Без наличный',
            ],
            [
                'name' => 'Отсрочка',
            ],
            [
                'name' => 'Kaspi',
            ],
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_types');
    }
};
