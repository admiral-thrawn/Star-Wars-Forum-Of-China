<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class Abilities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abilities', function (Blueprint $table) {
             $table->engine = 'InnoDB';
             $table->charset = 'utf8mb4';
             $table->collation = 'utf8mb4_unicode_ci';
            // CONTENT
            $table->bigIncrements('id')->nullable(false)->comment('');
			$table->string('name', 255)->nullable(false)->comment('');
			$table->string('title', 255)->nullable()->default(null)->comment('');
			$table->char('entity_id', 36)->nullable()->default(null)->comment('');
			$table->string('entity_type', 255)->nullable()->default(null)->comment('');
			$table->boolean('only_owned')->nullable(false)->default(0)->comment('');
			$table->json('options')->nullable()->comment('');
			$table->integer('scope')->nullable()->default(null)->comment('');
			$table->timestamp('created_at')->comment('');
			$table->timestamp('updated_at')->comment('');
			$table->index('scope', 'abilities_scope_index');
			
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('abilities');
    }
}
