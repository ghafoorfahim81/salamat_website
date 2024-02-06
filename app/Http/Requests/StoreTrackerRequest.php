<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrackerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'sender_id' => '',
            'receiver_directorate_id' => 'required',
            'in_num' => 'required',
            'out_num' => 'required',
            'in_date' => 'required',
            'out_date' => 'required',
            'phone_number' => 'required',
            'focal_point_name' => 'required',
            'request_deadline' => 'required',
            'remark' =>'required',
            'attachment_count' => 'required',
            'deadline_id' => 'required | exists:deadlines,id',
            'status_id' => 'required | exists:statuses,id',
            'deadline_type_id' => 'required | exists:deadline_types,id',
            'security_level_id' => 'required | exists:security_levels,id',
            'followup_type_id' => 'required | exists:followup_types,id',
            'document_id' => 'required | exists:documents,id',
            'doc_type_id' => 'required | exists:doc_types,id',
            'conclusion' => 'required',
            'decision_subject' => 'required',
            'assigned_department' => '',
        ];
    }
}
