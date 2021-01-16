<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class Likes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
             $table->engine = 'InnoDB';
             $table->charset = 'utf8mb4';
             $table->collation = 'utf8mb4_unicode_ci';
            // CONTENT
            $table->bigIncrements('id')->nullable(false)->comment('');
			$table->char('user_id', 36)->nullable(false)->comment('user_id');
			$table->string('likeable_type', 255)->nullable(false)->comment('');
			$table->char('likeable_id', 36)->nullable(false)->comment('');
			$table->timestamp('created_at')->comment('');
			$table->timestamp('updated_at')->comment('');
			$table->index(['likeable_type','likeable_id'], 'likes_likeable_type_likeable_id_index');
			$table->index('user_id', 'likes_user_id_index');
			
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likes');
    }
}
