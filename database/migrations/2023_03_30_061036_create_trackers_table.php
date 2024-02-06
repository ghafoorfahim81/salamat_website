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
        Schema::create('trackers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained()->nullable()->onUpdate('cascade')->onDelete('cascade')->index();
            $table->bigInteger('sender_employee_id')->nullable();
            $table->bigInteger('sender_directorate_id')->nullable();
            $table->bigInteger('receiver_employee_id')->nullable();
            $table->bigInteger('receiver_directorate_id')->nullable();
            $table->foreignId('status_id')->constrained()->nullable();
            $table->foreignId('doc_type_id')->constrained()->nullable();
            $table->bigInteger('in_num')->nullable();
            $table->string('in_doc_prefix', 10)->nullable();
            $table->bigInteger('out_num')->nullable();
            $table->string('out_doc_prefix', 10)->nullable();
            $table->date('in_date')->nullable();
            $table->date('out_date')->nullable();

            $table->enum('type',['external', 'internal']);
            $table->enum('in_out',['in', 'out'])->nullable();

            $table->smallInteger('request_deadline')->nullable();
            $table->string('phone_number', 15)->nullable();
            $table->string('focal_point_name', 50)->nullable();
            $table->text('remark')->nullable();
            $table->smallInteger('attachment_count')->nullable();
            $table->text('conclusion')->nullable();
            $table->text('decision_subject')->nullable();
            $table->foreignId('deadline_id')->nullable();
            $table->foreignId('deadline_type_id')->constrained()->nullable();
            $table->foreignId('security_level_id')->constrained()->nullable();
            $table->foreignId('followup_type_id')->constrained()->nullable();
            $table->boolean('is_checked')->default(0);
            $table->date('is_checked_date')->nullable();
            $table->uuid('created_by');
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trackers');
    }
};
