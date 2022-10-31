<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string("title")->default('');
            $table->text("body");
            $table->string('slug')->default('');
            $table->string('title_hash');
            $table->string('link')->nullable();
            $table->string("cover_image_url")->default('');
            $table->unsignedBigInteger('server_id');
            $table->unsignedInteger('is_positive')->default(0);
            $table->unsignedInteger('is_negative')->default(0);
            $table->unsignedInteger('favorit_count')->default(0);
            $table->unsignedInteger('comment_count')->default(0);
            $table->timestamps();
            $table->foreign('server_id')->on('news_servers')->references('id');
            $table->softDeletes();
        });
    }

    /**
     * 
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}
