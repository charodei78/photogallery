<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20);
            $table->bigInteger('album_id')->unsigned();
            $table->foreign('album_id')
                ->onDelete('cascade')
                ->references('id')
                ->on('albums');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                ->onDelete('cascade')
                ->references('id')
                ->on('users');
            $table->string('path');
            $table->string('path_resize');
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
        Schema::dropIfExists('images');
    }
}
