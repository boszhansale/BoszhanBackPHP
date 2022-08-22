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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salesrep_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('driver_id')->constrained('users')->cascadeOnDelete();

            $table->foreignId('store_id')->constrained('stores')->cascadeOnDelete();
            $table->foreignId('status_id')->default(1)->constrained('statuses')->cascadeOnDelete();

            $table->string('mobile_id')->unique();

            $table->foreignId('payment_type_id')->default(1)->constrained('payment_types')->cascadeOnDelete();
            $table->foreignId('payment_status_id')->default(2)->constrained('payment_statuses')->cascadeOnDelete();


            $table->boolean('payment_full')->nullable();
            $table->integer('payment_partial')->nullable();


            $table->string('winning_name')->nullable()->default("");
            $table->string('winning_phone')->nullable()->default("");
            $table->smallInteger('winning_status')->default(1);

            $table->boolean('rnk_generate')->default(0);
            $table->boolean('db_export')->default(0);

            $table->timestamp('delivery_date')->nullable();
            $table->timestamp('delivered_date')->nullable();

            $table->float('purchase_price')->nullable();
            $table->float('return_price')->nullable();
            $table->float('salesrep_mobile_app_version')->default('1.6');
            $table->boolean('export_1c')->default('0');

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
        Schema::dropIfExists('orders');
    }
};
