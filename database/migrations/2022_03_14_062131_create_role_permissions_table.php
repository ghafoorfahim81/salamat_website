<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('role_permissions'))
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->uuid('id')->primary();;
            // $table->uuid('role_id')->index();
            $table->foreignUuid('role_id')->references('id')->on('roles');
            // $table->uuid('permission_id')->index();
            $table->foreignUuid('permission_id')->references('id')->on('permissions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_permissions');
    }
};
