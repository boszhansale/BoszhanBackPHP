<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('label_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        \App\Models\LabelCategory::create(['name' => 'Бифимбилль']);
        \App\Models\LabelCategory::create(['name' => 'Колбаса и деликатесы']);
        \App\Models\LabelCategory::create(['name' => 'Колбаски гриль, бургеры, фарш']);
        \App\Models\LabelCategory::create(['name' => 'Мясо кордай']);
        \App\Models\LabelCategory::create(['name' => 'Мясо штучное']);
        \App\Models\LabelCategory::create(['name' => 'ООП ПФ Колбаса']);
        \App\Models\LabelCategory::create(['name' => 'Полуфабрикаты']);

        Schema::table('label_products', function (Blueprint $table) {
            $table->foreignId('label_category_id')->default(1)->constrained('label_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('label_categories');
    }
};
