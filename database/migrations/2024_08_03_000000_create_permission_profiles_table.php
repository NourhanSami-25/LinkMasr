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
        Schema::create('permission_profiles', function (Blueprint $table) {
            $table->id();

            ###################################### project
            $table->boolean('project_view_global')->default(false);
            $table->boolean('project_view_own')->default(false);
            $table->boolean('project_create')->default(false);
            $table->boolean('project_update')->default(false);
            $table->boolean('project_delete')->default(false);

            ###################################### task
            $table->boolean('task_view_global')->default(false);
            $table->boolean('task_view_own')->default(false);
            $table->boolean('task_create')->default(false);
            $table->boolean('task_update')->default(false);
            $table->boolean('task_delete')->default(false);

            $table->boolean('task_checklist_template_view_global')->default(false);
            $table->boolean('task_checklist_template_view_own')->default(false);
            $table->boolean('task_checklist_template_create')->default(false);
            $table->boolean('task_checklist_template_update')->default(false);
            $table->boolean('task_checklist_template_delete')->default(false);

            ###################################### timesheet
            $table->boolean('timesheet_attendance_view_global')->default(false);
            $table->boolean('timesheet_attendance_view_own')->default(false);
            $table->boolean('timesheet_attendance_create')->default(false);
            $table->boolean('timesheet_attendance_update')->default(false);
            $table->boolean('timesheet_attendance_delete')->default(false);

            $table->boolean('timesheet_work_shift_table_view_global')->default(false);
            $table->boolean('timesheet_work_shift_table_view_own')->default(false);
            $table->boolean('timesheet_work_shift_table_create')->default(false);
            $table->boolean('timesheet_work_shift_table_update')->default(false);
            $table->boolean('timesheet_work_shift_table_delete')->default(false);

            $table->boolean('timesheet_report_view_global')->default(false);
            $table->boolean('timesheet_report_view_own')->default(false);
            $table->boolean('timesheet_report_create')->default(false);
            $table->boolean('timesheet_report_update')->default(false);
            $table->boolean('timesheet_report_delete')->default(false);

            $table->boolean('timesheet_workplace_management_view_global')->default(false);
            $table->boolean('timesheet_workplace_management_view_own')->default(false);
            $table->boolean('timesheet_workplace_management_create')->default(false);
            $table->boolean('timesheet_workplace_management_update')->default(false);
            $table->boolean('timesheet_workplace_management_delete')->default(false);
            
            ###################################### client
            $table->boolean('client_view_global')->default(false);
            $table->boolean('client_view_own')->default(false);
            $table->boolean('client_create')->default(false);
            $table->boolean('client_update')->default(false);
            $table->boolean('client_delete')->default(false);

            $table->boolean('client_statistic_view_global')->default(false);
            $table->boolean('client_statistic_view_own')->default(false);
            $table->boolean('client_statistic_create')->default(false);
            $table->boolean('client_statistic_update')->default(false);
            $table->boolean('client_statistic_delete')->default(false);

            $table->boolean('client_services_report_view_global')->default(false);
            $table->boolean('client_services_report_view_own')->default(false);
            $table->boolean('client_services_report_create')->default(false);
            $table->boolean('client_services_report_update')->default(false);
            $table->boolean('client_services_report_delete')->default(false);

            $table->boolean('export_customer_detail_view_global')->default(false);
            $table->boolean('export_customer_detail_view_own')->default(false);
            $table->boolean('export_customer_detail_create')->default(false);
            $table->boolean('export_customer_detail_update')->default(false);
            $table->boolean('export_customer_detail_delete')->default(false);

            ###################################### finance
            $table->boolean('payment_request_view_global')->default(false);
            $table->boolean('payment_request_view_own')->default(false);
            $table->boolean('payment_request_create')->default(false);
            $table->boolean('payment_request_update')->default(false);
            $table->boolean('payment_request_delete')->default(false);

            $table->boolean('invoice_view_global')->default(false);
            $table->boolean('invoice_view_own')->default(false);
            $table->boolean('invoice_create')->default(false);
            $table->boolean('invoice_update')->default(false);
            $table->boolean('invoice_delete')->default(false);

            $table->boolean('credit_note_view_global')->default(false);
            $table->boolean('credit_note_view_own')->default(false);
            $table->boolean('credit_note_create')->default(false);
            $table->boolean('credit_note_update')->default(false);
            $table->boolean('credit_note_delete')->default(false);

            $table->boolean('payment_view_global')->default(false);
            $table->boolean('payment_view_own')->default(false);
            $table->boolean('payment_create')->default(false);
            $table->boolean('payment_update')->default(false);
            $table->boolean('payment_delete')->default(false);

            $table->boolean('expense_view_global')->default(false);
            $table->boolean('expense_view_own')->default(false);
            $table->boolean('expense_create')->default(false);
            $table->boolean('expense_update')->default(false);
            $table->boolean('expense_delete')->default(false);

            $table->boolean('item_view_global')->default(false);
            $table->boolean('item_view_own')->default(false);
            $table->boolean('item_create')->default(false);
            $table->boolean('item_update')->default(false);
            $table->boolean('item_delete')->default(false);
            
            
            ###################################### request
            $table->boolean('estimate_request_view_global')->default(false);
            $table->boolean('estimate_request_view_own')->default(false);
            $table->boolean('estimate_request_create')->default(false);
            $table->boolean('estimate_request_update')->default(false);
            $table->boolean('estimate_request_delete')->default(false);

            $table->boolean('leave_view_global')->default(false);
            $table->boolean('leave_view_own')->default(false);
            $table->boolean('leave_create')->default(false);
            $table->boolean('leave_update')->default(false);
            $table->boolean('leave_delete')->default(false);

            $table->boolean('additional_work_hour_view_global')->default(false);
            $table->boolean('additional_work_hour_view_own')->default(false);
            $table->boolean('additional_work_hour_create')->default(false);
            $table->boolean('additional_work_hour_update')->default(false);
            $table->boolean('additional_work_hour_delete')->default(false);

            ###################################### bussiness
            $table->boolean('lead_view_global')->default(false);
            $table->boolean('lead_view_own')->default(false);
            $table->boolean('lead_create')->default(false);
            $table->boolean('lead_update')->default(false);
            $table->boolean('lead_delete')->default(false);

            $table->boolean('contract_view_global')->default(false);
            $table->boolean('contract_view_own')->default(false);
            $table->boolean('contract_create')->default(false);
            $table->boolean('contract_update')->default(false);
            $table->boolean('contract_delete')->default(false);

            $table->boolean('proposal_view_global')->default(false);
            $table->boolean('proposal_view_own')->default(false);
            $table->boolean('proposal_create')->default(false);
            $table->boolean('proposal_update')->default(false);
            $table->boolean('proposal_delete')->default(false);
            
            ###################################### utility
            $table->boolean('goal_view_global')->default(false);
            $table->boolean('goal_view_own')->default(false);
            $table->boolean('goal_create')->default(false);
            $table->boolean('goal_update')->default(false);
            $table->boolean('goal_delete')->default(false);

            $table->boolean('reminder_view_global')->default(false);
            $table->boolean('reminder_view_own')->default(false);
            $table->boolean('reminder_create')->default(false);
            $table->boolean('reminder_update')->default(false);
            $table->boolean('reminder_delete')->default(false);

            ###################################### report
            $table->boolean('report_view_global')->default(false);
            $table->boolean('report_view_own')->default(false);
            $table->boolean('report_create')->default(false);
            $table->boolean('report_update')->default(false);
            $table->boolean('report_delete')->default(false);

            $table->boolean('finance_pdf_reports_view_global')->default(false);
            $table->boolean('finance_pdf_reports_view_own')->default(false);
            $table->boolean('finance_pdf_reports_create')->default(false);
            $table->boolean('finance_pdf_reports_update')->default(false);
            $table->boolean('finance_pdf_reports_delete')->default(false);

            $table->boolean('knowledge_base_view_global')->default(false);
            $table->boolean('knowledge_base_view_own')->default(false);
            $table->boolean('knowledge_base_create')->default(false);
            $table->boolean('knowledge_base_update')->default(false);
            $table->boolean('knowledge_base_delete')->default(false);

            ###################################### email
            $table->boolean('email_template_view_global')->default(false);
            $table->boolean('email_template_view_own')->default(false);
            $table->boolean('email_template_create')->default(false);
            $table->boolean('email_template_update')->default(false);
            $table->boolean('email_template_delete')->default(false);
            
            ###################################### staff
            $table->boolean('staff_view_global')->default(false);
            $table->boolean('staff_view_own')->default(false);
            $table->boolean('staff_create')->default(false);
            $table->boolean('staff_update')->default(false);
            $table->boolean('staff_delete')->default(false);

            $table->boolean('staff_role_view_global')->default(false);
            $table->boolean('staff_role_view_own')->default(false);
            $table->boolean('staff_role_create')->default(false);
            $table->boolean('staff_role_update')->default(false);
            $table->boolean('staff_role_delete')->default(false);

            ###################################### hr
            $table->boolean('hr_dashboard_view_global')->default(false);
            $table->boolean('hr_dashboard_view_own')->default(false);
            $table->boolean('hr_dashboard_create')->default(false);
            $table->boolean('hr_dashboard_update')->default(false);
            $table->boolean('hr_dashboard_delete')->default(false);

            $table->boolean('hr_department_view_global')->default(false);
            $table->boolean('hr_department_view_own')->default(false);
            $table->boolean('hr_department_create')->default(false);
            $table->boolean('hr_department_update')->default(false);
            $table->boolean('hr_department_delete')->default(false);

            $table->boolean('hr_checklist_view_global')->default(false);
            $table->boolean('hr_checklist_view_own')->default(false);
            $table->boolean('hr_checklist_create')->default(false);
            $table->boolean('hr_checklist_update')->default(false);
            $table->boolean('hr_checklist_delete')->default(false);

            $table->boolean('hr_record_view_global')->default(false);
            $table->boolean('hr_record_view_own')->default(false);
            $table->boolean('hr_record_create')->default(false);
            $table->boolean('hr_record_update')->default(false);
            $table->boolean('hr_record_delete')->default(false);

            $table->boolean('hr_job_description_view_global')->default(false);
            $table->boolean('hr_job_description_view_own')->default(false);
            $table->boolean('hr_job_description_create')->default(false);
            $table->boolean('hr_job_description_update')->default(false);
            $table->boolean('hr_job_description_delete')->default(false);

            $table->boolean('hr_training_view_global')->default(false);
            $table->boolean('hr_training_view_own')->default(false);
            $table->boolean('hr_training_create')->default(false);
            $table->boolean('hr_training_update')->default(false);
            $table->boolean('hr_training_delete')->default(false);

            $table->boolean('hr_q_a_view_global')->default(false);
            $table->boolean('hr_q_a_view_own')->default(false);
            $table->boolean('hr_q_a_create')->default(false);
            $table->boolean('hr_q_a_update')->default(false);
            $table->boolean('hr_q_a_delete')->default(false);

            $table->boolean('hr_contract_view_global')->default(false);
            $table->boolean('hr_contract_view_own')->default(false);
            $table->boolean('hr_contract_create')->default(false);
            $table->boolean('hr_contract_update')->default(false);
            $table->boolean('hr_contract_delete')->default(false);

            $table->boolean('hr_manage_penalty_view_global')->default(false);
            $table->boolean('hr_manage_penalty_view_own')->default(false);
            $table->boolean('hr_manage_penalty_create')->default(false);
            $table->boolean('hr_manage_penalty_update')->default(false);
            $table->boolean('hr_manage_penalty_delete')->default(false);

            $table->boolean('hr_layoff_checklist_view_global')->default(false);
            $table->boolean('hr_layoff_checklist_view_own')->default(false);
            $table->boolean('hr_layoff_checklist_create')->default(false);
            $table->boolean('hr_layoff_checklist_update')->default(false);
            $table->boolean('hr_layoff_checklist_delete')->default(false);

            $table->boolean('hr_report_view_global')->default(false);
            $table->boolean('hr_report_view_own')->default(false);
            $table->boolean('hr_report_create')->default(false);
            $table->boolean('hr_report_update')->default(false);
            $table->boolean('hr_report_delete')->default(false);

            $table->boolean('hr_setting_view_global')->default(false);
            $table->boolean('hr_setting_view_own')->default(false);
            $table->boolean('hr_setting_create')->default(false);
            $table->boolean('hr_setting_update')->default(false);
            $table->boolean('hr_setting_delete')->default(false);

            ###################################### settings
            $table->boolean('setting_view_global')->default(false);
            $table->boolean('setting_view_own')->default(false);
            $table->boolean('setting_create')->default(false);
            $table->boolean('setting_update')->default(false);
            $table->boolean('setting_delete')->default(false);

            $table->boolean('subscription_view_global')->default(false);
            $table->boolean('subscription_view_own')->default(false);
            $table->boolean('subscription_create')->default(false);
            $table->boolean('subscription_update')->default(false);
            $table->boolean('subscription_delete')->default(false);

            ###################################### OTHER
            $table->boolean('work_route_view_global')->default(false);
            $table->boolean('work_route_view_own')->default(false);
            $table->boolean('work_route_create')->default(false);
            $table->boolean('work_route_update')->default(false);
            $table->boolean('work_route_delete')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_profiles');
    }
};
