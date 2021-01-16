<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('title', 45);
            $table->string('description', 250);
            $table->string('content', 8000);
            $table->char('author_id', 36)->nullable()->index('articles_author_id_foreign');
            $table->char('topic_id', 36)->nullable()->index('articles_topic_id_foreign');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
