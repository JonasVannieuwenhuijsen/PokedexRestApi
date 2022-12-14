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
        Schema::create('version_group_details', function (Blueprint $table) {
            $table->id();
            $table->string('move_learn_method');
            $table->string('version_group');
            $table->decimal('level_learned_at');
            $table->integer('move_id');
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
        Schema::dropIfExists('version_group_details');
    }
};
