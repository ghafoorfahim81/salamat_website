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
        Schema::create('out_docs', function (Blueprint $table) {
            $table->id();
            $table->date('sent_doc_date')->nullable();
            $table->string('sent_doc_prefix', 10)->nullable();
            $table->string('sent_doc_number', 255)->nullable();
            $table->integer('sent_by_id')->nullable();
            $table->string('sender_name', 255)->nullable();
            $table->string('sender_phone', 255)->nullable();
            $table->string('sender_email', 255)->nullable();
            $table->integer('send_to_id')->nullable();
            $table->string('document_name', 255)->nullable();
            $table->integer('security_level')->nullable();
            $table->integer('document_type')->nullable();
            $table->integer('out_doc_link_type')->nullable();
            $table->integer('out_doc_link_id')->nullable();
            $table->date('out_doc_link_date')->nullable();
            $table->integer('in_doc_link_type')->nullable();
            $table->integer('in_doc_link_id')->nullable();
            $table->integer('in_doc_link_date')->nullable();
            $table->string('description', 255)->nullable();
            $table->string('attachments', 255)->nullable();
            $table->integer('attachments_count')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('out_docs');
    }
};
