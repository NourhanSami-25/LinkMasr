<?php

namespace App\Http\Requests\common;

use Illuminate\Foundation\Http\FormRequest;

class FileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // 'file' => 'required|file|max:20480|mimetypes:application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,text/csv,image/jpeg,image/png,application/x-rar-compressed',
            // 'file' => 'required|file|max:2048|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|mimetypes:application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,text/csv,image/jpeg,image/png,application/x-rar-compressed',
            'name' => 'required|string',
            'category' => 'nullable|string',
            'file' => 'required|file|max:20480|mimes:ico,png,jpg,jpeg,svg,jpf,pdf,doc,docx,xls,xlsx,zip,rar,txt,psd,mp3,mp4,ogg,opus,7z,gif,eps,ppt,pptx,ai,html,php',
            'model_id' => 'required|integer',
            'model_type' => 'required|string',
            'description' => 'nullable|string',

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The file name is required.',
            'file.required' => 'The file is required.',
            'file.file' => 'The uploaded file must be a valid file.',
            'file.max' => 'The file size must not exceed 20 MB.',
            'file.mimes' => 'The file must be one of the following types: jpg, jpeg, png, pdf, doc, docx, xls, xlsx.',
            'file.mimetypes' => 'The file type is not supported.',
            'model_id.required' => 'The model ID is required.',
            'model_id.integer' => 'The model ID must be an integer.',
            'model_type.required' => 'The model type is required.',
            'model_type.string' => 'The model type must be a string.',
            'description.string' => 'The description must be a string.',
        ];
    }
}
