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
        Schema::create('in_doc_attachments', function (Blueprint $table) {
            $table->id();
            $table->integer('doc_id')->nullable();
            $table->integer('link_id')->nullable();
            $table->string('type', 100)->nullable();
            $table->string('doc_link_type', 100)->nullable();
            $table->string('doc_link_id', 100)->nullable();
            $table->dateTime('doc_link_date')->nullable();
            $table->date('deleted_at')->nullable();
            $table->date('deleted_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('in_doc_attachments');
    }
};
