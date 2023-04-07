<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    private $table = 'category';
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
        $id = $this->id;
        $valName = "bail|required|between:5,100|unique:$this->table,name";
        if (!empty($id)) {
            $valName .= ",$id";
        }
        return [
            'name' => $valName,
            'status' => 'bail|required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name không được để trống!',
            'status.required' => 'Status không được để trống!',
            'name.between' => 'Chuỗi không được bé hơn 5 và lớn hơn 100 ký tự!',
            'name.unique' => 'Name đã tồn tại!',
        ];
    }
}
