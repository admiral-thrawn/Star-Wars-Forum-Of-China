<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class Tags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
             $table->engine = 'InnoDB';
             $table->charset = 'utf8mb4';
             $table->collation = 'utf8mb4_unicode_ci';
            // CONTENT
            $table->bigIncrements('id')->nullable(false)->comment('');
			$table->json('name')->nullable(false)->comment('');
			$table->json('slug')->nullable(false)->comment('');
			$table->string('type', 255)->nullable()->default(null)->comment('');
			$table->integer('order_column')->nullable()->default(null)->comment('');
			$table->timestamp('created_at')->comment('');
			$table->timestamp('updated_at')->comment('');
			
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags');
    }
}
