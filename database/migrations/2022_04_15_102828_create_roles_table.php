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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->softDeletes();
            $table->timestamps();
        });
        \App\Models\Role::insert([
            [
                'name' => 'salesrep',
                'description' => 'Торговый представитель',
            ],
            [
                'name' => 'driver',
                'description' => 'Водитель',
            ],
            [
                'name' => 'admin',
                'description' => 'Админ',
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
