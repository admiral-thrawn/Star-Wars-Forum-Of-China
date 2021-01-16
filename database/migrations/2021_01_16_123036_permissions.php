<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class Permissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
             $table->engine = 'InnoDB';
             $table->charset = 'utf8mb4';
             $table->collation = 'utf8mb4_unicode_ci';
            // CONTENT
            $table->bigIncrements('id')->nullable(false)->comment('');
			$table->unsignedBigInteger('ability_id')->nullable(false)->comment('');
			$table->string('entity_id', 36)->nullable()->default(null)->comment('');
			$table->string('entity_type', 255)->nullable()->default(null)->comment('');
			$table->boolean('forbidden')->nullable(false)->default(0)->comment('');
			$table->integer('scope')->nullable()->default(null)->comment('');
			$table->index('ability_id', 'permissions_ability_id_index');
			$table->index(['entity_id','entity_type','scope'], 'permissions_entity_index');
			$table->index('scope', 'permissions_scope_index');
			
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
