<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TopicsForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('topics', function (Blueprint $table) {
            // CONTENT
            $table->foreign('author_id')
                           ->references('id')
                           ->on('users')
                           ->onDelete('no action')
                           ->onUpdate('no action');
        });
    }
}
