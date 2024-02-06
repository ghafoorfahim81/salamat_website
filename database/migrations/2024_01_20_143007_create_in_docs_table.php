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
        Schema::create('in_docs', function (Blueprint $table) {
            $table->id();
            $table->date('sent_doc_date')->nullable();
            $table->integer('sent_doc_number')->nullable();
            $table->integer('sent_by_id')->nullable();
            $table->string('sender_name', 255)->nullable();
            $table->string('sender_phone', 50)->nullable();
            $table->string('sender_email', 255)->nullable();
            $table->date('incoming_date')->nullable();
            $table->string('incoming_doc_prefix', 50);
            $table->integer('incoming_doc_number')->nullable();
            $table->integer('send_to_id')->nullable();
            $table->string('document_name', 255)->nullable();
            $table->string('security_level')->nullable();
            $table->string('document_type')->nullable();
            $table->string('deadline')->nullable();
            $table->string('status')->nullable();
            $table->string('out_doc_link_id')->nullable();
            $table->string('out_doc_link_date')->nullable();
            $table->string('in_doc_link_type')->nullable();
            $table->string('in_doc_link_id')->nullable();
            $table->string('in_doc_link_date')->nullable();
            $table->string('description')->nullable();
            $table->string('attachments')->nullable();
            $table->string('attachment_count')->nullable();
            $table->string('completed_date')->nullable();
            $table->string('sms_sent')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->dateTime('created_by')->nullable();
            $table->dateTime('updated_by')->nullable();
            $table->dateTime('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('in_docs');
    }
};
