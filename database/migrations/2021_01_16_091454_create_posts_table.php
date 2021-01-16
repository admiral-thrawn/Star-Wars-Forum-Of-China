<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('title', 100);
            $table->string('content', 2000);
            $table->char('author_id', 36)->index('posts_author_id_foreign');
            $table->char('parent_id', 36)->nullable();
            $table->char('topic_id', 36)->nullable()->index('posts_topic_id_foreign');
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
        Schema::dropIfExists('posts');
    }
}
