<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NotificationUserForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notification_user', function (Blueprint $table) {
            // CONTENT
            $table->foreign('notification_id')
                           ->references('id')
                           ->on('notifications')
                           ->onDelete('no action')
                           ->onUpdate('no action');
$table->foreign('user_id')
                           ->references('id')
                           ->on('users')
                           ->onDelete('no action')
                           ->onUpdate('no action');
        });
    }
}
