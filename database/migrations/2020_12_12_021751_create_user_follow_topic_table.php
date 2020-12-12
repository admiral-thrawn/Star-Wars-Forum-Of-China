<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFollowTopicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_follow_topic', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('follower_id')->constrained('users');
            $table->foreignUuid('topic_id')->constrained('topics');
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
        Schema::dropIfExists('user_follow_topic');
    }
}
