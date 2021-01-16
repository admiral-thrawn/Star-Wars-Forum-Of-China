<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TaggablesForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('taggables', function (Blueprint $table) {
            // CONTENT
            $table->foreign('tag_id')
                           ->references('id')
                           ->on('tags')
                           ->onDelete('cascade')
                           ->onUpdate('no action');
        });
    }
}
