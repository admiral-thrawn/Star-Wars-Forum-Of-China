<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ArticlesForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            // CONTENT
            $table->foreign('author_id')
                           ->references('id')
                           ->on('users')
                           ->onDelete('no action')
                           ->onUpdate('no action');
$table->foreign('topic_id')
                           ->references('id')
                           ->on('topics')
                           ->onDelete('no action')
                           ->onUpdate('no action');
        });
    }
}
