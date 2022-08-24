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
        Schema::create('sprites', function (Blueprint $table) {
            $table->id();
            $table->string('front_default')->nullable();
            $table->string('front_female')->nullable();
            $table->string('front_shiny')->nullable();
            $table->string('front_shiny_female')->nullable();
            $table->string('back_default')->nullable();
            $table->string('back_female')->nullable();
            $table->string('back_shiny')->nullable();
            $table->string('back_shiny_female')->nullable();
            $table->integer('pokemon_id');
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
        Schema::dropIfExists('sprites');
    }
};
