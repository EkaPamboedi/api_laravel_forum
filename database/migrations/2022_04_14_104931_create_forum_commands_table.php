<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForumCommandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_commands', function (Blueprint $table) {
            $table->id();
            $table->UnsignedBigInteger('forum_id');
            $table->UnsignedBigInteger('user_id');
            $table->string('body');
            $table->string('category');
            $table->timestamps();

            $table->foreign('forum_id')->references('id')->on('forum');
            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forum_commands');
    }
}
