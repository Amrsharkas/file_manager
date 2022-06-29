<?php

namespace ie\fm\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RenameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_name'=>'required',
            'newName'=>'required',
            'path'=>'required',
            'type'=>'required'
        ];
    }
}
