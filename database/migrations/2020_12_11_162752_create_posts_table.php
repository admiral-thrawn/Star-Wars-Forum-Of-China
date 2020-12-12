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

            $table->charset = 'utf8mb4';

            $table->uuid('id')->primary();
            $table->string('title', 100);
            $table->string('content', 2000);
            $table->foreignUuid('author_id',)->constrained('users');
            $table->uuid('parent_id');
            $table->foreignUuid('topic_id')
                ->nullable()
                ->constrained('topics');
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
