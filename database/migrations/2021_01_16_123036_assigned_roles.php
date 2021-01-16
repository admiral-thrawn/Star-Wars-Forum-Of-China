<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AssignedRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assigned_roles', function (Blueprint $table) {
             $table->engine = 'InnoDB';
             $table->charset = 'utf8mb4';
             $table->collation = 'utf8mb4_unicode_ci';
            // CONTENT
            $table->bigIncrements('id')->nullable(false)->comment('');
			$table->bigInteger('role_id')->nullable(false)->comment('');
			$table->char('entity_id', 36)->nullable(false)->comment('');
			$table->string('entity_type', 255)->nullable(false)->comment('');
			$table->unsignedBigInteger('restricted_to_id')->nullable()->default(null)->comment('');
			$table->string('restricted_to_type', 255)->nullable()->default(null)->comment('');
			$table->integer('scope')->nullable()->default(null)->comment('');
			$table->index(['entity_id','entity_type','scope'], 'assigned_roles_entity_index');
			$table->index('role_id', 'assigned_roles_role_id_index');
			$table->index('scope', 'assigned_roles_scope_index');
			
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assigned_roles');
    }
}
