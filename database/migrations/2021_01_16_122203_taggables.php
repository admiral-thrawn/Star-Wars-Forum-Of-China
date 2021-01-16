<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class Taggables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taggables', function (Blueprint $table) {
             $table->engine = 'InnoDB';
             $table->charset = 'utf8mb4';
             $table->collation = 'utf8mb4_unicode_ci';
            // CONTENT
            $table->unsignedBigInteger('tag_id')->nullable(false)->comment('');
			$table->string('taggable_type', 255)->nullable(false)->comment('');
			$table->char('taggable_id', 36)->nullable(false)->comment('');
			$table->unique('tag_id', 'taggables_tag_id_taggable_id_taggable_type_unique');
			$table->index(['taggable_type','taggable_id'], 'taggables_taggable_type_taggable_id_index');
			$table->index('tag_id', 'IDX_A9D1878EBAD26311');
			
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taggables');
    }
}
