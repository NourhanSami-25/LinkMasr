<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->id();

            $table->string('subject', 255)->nullable();               // اسم القضية
            $table->string('company_name', 255)->nullable();            // اسم الشركة
            $table->string('client_name', 255)->nullable();             // اسم العميل
            $table->string('litigant', 255)->nullable();                // الخصم
            $table->string('description', 2048)->nullable();             // الوصف
            $table->string('number', 50)->nullable();             // رقم القضية
            $table->year('year')->nullable();               // سنة القضية
            $table->string('payment_type', 50)->nullable();            // نوع الدفع
            $table->string('tags', 255)->nullable();                    // تاجز
            $table->string('status', 50)->nullable();                  // الحالة
            $table->string('hold_reason', 255)->nullable();             // سبب التوقف
            $table->string('close_reason', 255)->nullable();            // سبب الاغلاق
            $table->string('final_judgment', 255)->nullable();          // الحكم النهائي
            $table->string('court_name', 50)->nullable();              // اسم المحكمة
            $table->string('court_type', 50)->nullable();              // نوع المحكمة
            $table->string('court_level', 50)->nullable();             // مستوي المحكمة

            // Date columns
            $table->date('start_date')->nullable();                     // تاريخ البدء
            $table->date('due_date')->nullable();                       // تاريخ الانتهاء
            $table->date('final_judgment_date')->nullable();            // تاريخ الحكم النهائي
            $table->date('hold_date')->nullable();            // تاريخ الحكم النهائي
            $table->date('close_date')->nullable();            // تاريخ الحكم النهائي

            // Foreign keys (nullable, unsignedBigInteger)
            $table->unsignedBigInteger('project_id')->nullable();       // project_id
            $table->unsignedBigInteger('client_id')->nullable();        // client_id
            
            // Define foreign key constraints
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('set null');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');

            // Investment Court Details : inc
            $table->string('inc_party_type', 50)->nullable();               // نوع الطرف
            $table->string('inc_identity_type', 50)->nullable();            // نوع اثبات الشخصية
            $table->string('inc_order', 50)->nullable();                    // الترتيب
            $table->string('inc_identity_number', 50)->nullable();          // رقم اثبات الشخصية
            $table->date('inc_expiry_date')->nullable();                     // تاريخ الانتهاء
            $table->string('inc_nationality', 50)->nullable();              // الجنسية
            $table->string('inc_issue_authority', 255)->nullable();          // جهة الاصدار
            $table->string('inc_full_name', 255)->nullable();                // الاسم الكامل
            $table->string('inc_passport_number', 50)->nullable();          // رقم جواز السفر
            $table->string('inc_tax_number', 50)->nullable();               // رقم التسجيل الضريبي
            $table->string('inc_entity_name', 255)->nullable();              // اسم المنشأة
            $table->date('inc_birth_date')->nullable();                      // تاريخ الميلاد
            $table->date('inc_tax_registration_date')->nullable();           // تاريخ السجل
            $table->string('inc_country', 50)->nullable();                  // البلد
            $table->string('inc_city', 50)->nullable();                     // المدينة
            $table->string('inc_area', 50)->nullable();                     // المنطقة
            $table->string('inc_street', 50)->nullable();                   // الشارع
            $table->string('inc_building', 50)->nullable();                 // المبني
            $table->string('inc_phone', 50)->nullable();                    // التليفون
            $table->string('inc_po_box', 50)->nullable();                   // صندوق البريد

            // Case Notification Settings & Permissions for Client
            $table->boolean('notify_creation_contacts')->default(true); // Send contacts notifications
            $table->boolean('notify_creation_client')->default(false); // Send creation mail to clint
            $table->boolean('client_view_tasks')->default(false); // Allow client to view tasks
            $table->boolean('client_create_tasks')->default(false); // Allow client to create tasks
            $table->boolean('client_edit_own_tasks')->default(false); // Allow client to edit tasks (only tasks created by contact)
            $table->boolean('client_comment_tasks')->default(false); // Allow client to comment on project tasks
            $table->boolean('client_view_task_comments')->default(false); // Allow client to view task comments
            $table->boolean('client_view_task_attachments')->default(false); // Allow client to view task attachments
            $table->boolean('client_view_task_checklist')->default(false); // Allow client to view task checklist items
            $table->boolean('client_upload_task_attachments')->default(false); // Allow client to upload attachments on tasks
            $table->boolean('client_view_task_time')->default(false); // Allow client to view task total logged time
            $table->boolean('client_view_finance')->default(false); // Allow client to view finance overview
            $table->boolean('client_upload_files')->default(false); // Allow client to upload files
            $table->boolean('client_open_cases')->default(false); // Allow client to open case status
            $table->boolean('client_view_milestones')->default(false); // Allow client to view milestones
            $table->boolean('client_view_gantt')->default(false); // Allow client to view Gantt
            $table->boolean('client_view_timesheets')->default(false); // Allow client to view timesheets
            $table->boolean('client_view_activity_log')->default(false); // Allow client to view activity log
            $table->boolean('client_view_team')->default(false); // Allow client to view team members

            // Timestamps & Creation Data
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });

        Schema::create('case_updates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('case_id')->nullable();
            $table->string('subject', 255)->nullable();
            $table->string('description', 1024)->nullable();
            $table->date('date')->nullable();
            $table->boolean('visible_to_client')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('case_id')->references('id')->on('cases')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('case_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('case_id')->nullable();
            $table->string('subject', 255)->nullable();
            $table->string('description', 1024)->nullable();
            $table->date('date')->nullable();
            $table->boolean('visible_to_client')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('case_id')->references('id')->on('cases')->onDelete('cascade');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('cases');
        Schema::dropIfExists('case_updates');
        Schema::dropIfExists('case_activities');
    }
};
