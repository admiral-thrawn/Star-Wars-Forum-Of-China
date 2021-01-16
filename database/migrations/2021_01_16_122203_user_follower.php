<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UserFollower extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_follower', function (Blueprint $table) {
             $table->engine = 'InnoDB';
             $table->charset = 'utf8mb4';
             $table->collation = 'utf8mb4_unicode_ci';
            // CONTENT
            $table->increments('id')->nullable(false)->comment('');
			$table->char('following_id', 36)->nullable(false)->comment('');
			$table->char('follower_id', 36)->nullable(false)->comment('');
			$table->timestamp('accepted_at')->comment('');
			$table->timestamp('created_at')->comment('');
			$table->timestamp('updated_at')->comment('');
			$table->index('accepted_at', 'user_follower_accepted_at_index');
			$table->index('follower_id', 'user_follower_follower_id_index');
			$table->index('following_id', 'user_follower_following_id_index');
			
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_follower');
    }
}
