<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class Notifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
             $table->engine = 'InnoDB';
             $table->charset = 'utf8mb4';
             $table->collation = 'utf8mb4_unicode_ci';
            // CONTENT
            $table->char('id', 36)->nullable(false)->comment('');
			$table->string('title', 250)->nullable(false)->comment('');
			$table->string('content', 2000)->nullable(false)->comment('');
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
        Schema::dropIfExists('notifications');
    }
}
