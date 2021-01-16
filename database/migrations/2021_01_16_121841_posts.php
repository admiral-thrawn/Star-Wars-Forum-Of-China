<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class Posts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
             $table->engine = 'InnoDB';
             $table->charset = 'utf8mb4';
             $table->collation = 'utf8mb4_unicode_ci';
            // CONTENT
            $table->char('id', 36)->nullable(false)->comment('');
			$table->string('title', 100)->nullable(false)->comment('');
			$table->string('content', 2000)->nullable(false)->comment('');
			$table->char('author_id', 36)->nullable(false)->comment('');
			$table->char('parent_id', 36)->nullable()->default(null)->comment('');
			$table->char('topic_id', 36)->nullable()->default(null)->comment('');
			$table->timestamp('created_at')->comment('');
			$table->timestamp('updated_at')->comment('');
			$table->timestamp('deleted_at')->comment('');
			$table->primary('id');
			
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
