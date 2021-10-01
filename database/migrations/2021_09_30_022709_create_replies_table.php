<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replies', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable()->comment('1==main comment, 2==reply');
            $table->unsignedBigInteger('comment_id');
            $table->integer('reply_comment_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('comment_user_id');
            $table->text('comment');
            $table->string('image')->nullable();
            $table->timestamps();
            $table->foreign('comment_id')->references('id')->on('comments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('replies');
    }
}
