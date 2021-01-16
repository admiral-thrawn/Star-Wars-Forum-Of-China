<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ability_id')->index();
            $table->string('entity_id', 36)->nullable();
            $table->string('entity_type')->nullable();
            $table->boolean('forbidden')->default(0);
            $table->integer('scope')->nullable()->index();
            $table->index(['entity_id', 'entity_type', 'scope'], 'permissions_entity_index');
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
