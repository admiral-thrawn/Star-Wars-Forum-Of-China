<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PermissionsForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permissions', function (Blueprint $table) {
            // CONTENT
            $table->foreign('ability_id')
                           ->references('id')
                           ->on('abilities')
                           ->onDelete('cascade')
                           ->onUpdate('cascade');
        });
    }
}
