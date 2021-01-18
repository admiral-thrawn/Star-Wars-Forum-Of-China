<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            // CONTENT
            $table->char('id', 36)->nullable(false)->comment('');
            $table->string('name', 255)->nullable(false)->comment('');
            $table->string('email', 255)->nullable(false)->comment('');
            $table->timestamp('email_verified_at')->comment('');
            $table->string('password', 255)->nullable(false)->comment('');
            $table->string('description', 400)->nullable(true)->default(null)->comment('');
            $table->string('description_raw', 300)->nullable(true)->default(null)->comment('');
            $table->string('background', 255)->nullable(true)->comment('');
            $table->string('remember_token', 100)->nullable(true)->default(null)->comment('');
            $table->timestamp('created_at')->comment('');
            $table->timestamp('updated_at')->comment('');
            $table->string('avatar', 100)->nullable(true)->comment('');
            $table->string('slogan', 100)->nullable(true)->comment('');
            $table->softDeletes();
            $table->primary('id');
            $table->unique('name', 'name_UNIQUE');
            $table->unique('email', 'users_email_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
