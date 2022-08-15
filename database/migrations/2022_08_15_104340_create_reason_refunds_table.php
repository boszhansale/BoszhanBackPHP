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
        Schema::create('reason_refunds', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->default(1); //Плановые возвраты,Внеплановые возврат
            $table->string('title')->nullable();
            $table->string('code')->nullable();
            $table->timestamps();
        });

        Schema::table('baskets',function (Blueprint $table){
            $table->foreignId('reason_refund_id')->nullable()->constrained('reason_refunds')->cascadeOnDelete();
            $table->text('comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reason_refunds');
    }
};
