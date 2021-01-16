<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class NotificationUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_user', function (Blueprint $table) {
             $table->engine = 'InnoDB';
             $table->charset = 'utf8mb4';
             $table->collation = 'utf8mb4_unicode_ci';
            // CONTENT
            $table->char('id', 36)->nullable(false)->comment('');
			$table->char('notification_id', 36)->nullable(false)->comment('');
			$table->char('user_id', 36)->nullable(false)->comment('');
			$table->timestamp('created_at')->comment('');
			$table->timestamp('updated_at')->comment('');
			$table->timestamp('deleted_at')->comment('');
			$table->primary('id');
			$table->index('notification_id', 'notification_user_notification_id_foreign');
			$table->index('user_id', 'notification_user_user_id_foreign');
			
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_user');
    }
}
