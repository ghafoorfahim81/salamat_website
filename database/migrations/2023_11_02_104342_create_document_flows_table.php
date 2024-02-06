<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('document_flows', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('document_id')->index('document_flow_fk');
            $table->string('status_slug');
            $table->date('date')->useCurrent();
            $table->string('remark', 50)->nullable();
//            $table->foreign('document_id', 'document_flow_fk')->references('id')->on('documents')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_flows');
    }
};
