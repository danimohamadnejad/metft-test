<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_servers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string("home_url");
            $table->string("feeds_url");
            $table->text('details')->nullable();
            $table->string('logo')->default('');
            $table->tinyInteger("status")->default(config('feedReader.feed-server-statuses.active.value'));
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
        Schema::dropIfExists('news_servers');
    }
}
