<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class PersonalAccessTokens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_access_tokens', function (Blueprint $table) {
             $table->engine = 'InnoDB';
             $table->charset = 'utf8mb4';
             $table->collation = 'utf8mb4_unicode_ci';
            // CONTENT
            $table->bigIncrements('id')->nullable(false)->comment('');
			$table->string('tokenable_type', 255)->nullable(false)->comment('');
			$table->char('tokenable_id', 36)->nullable(false)->comment('');
			$table->string('name', 255)->nullable(false)->comment('');
			$table->string('token', 64)->nullable(false)->comment('');
			$table->text('abilities')->nullable()->comment('');
			$table->timestamp('last_used_at')->comment('');
			$table->timestamp('created_at')->comment('');
			$table->timestamp('updated_at')->comment('');
			$table->unique('token', 'personal_access_tokens_token_unique');
			$table->index(['tokenable_type','tokenable_id'], 'personal_access_tokens_tokenable_type_tokenable_id_index');
			
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_access_tokens');
    }
}
