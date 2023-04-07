<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
{
    private $table = 'slider';
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
        $valThumb = 'bail|required|mimes:jpeg,png,jpg,gif,svg|max:2048';
        $valName = "bail|required|between:5,100|unique:$this->table,name";
        if (!empty($id)) {
            $valThumb = 'bail|mimes:jpeg,png,jpg,gif,svg|max:2048';
            $valName .= ",$id";
        }
        return [
            'name' => $valName,
            'description' => 'bail|required',
            'link' => 'bail|required|url',
            'status' => 'bail|required',
            'thumb' => $valThumb,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name không được để trống!',
            'description.required' => 'Description không được để trống!',
            'link.required' => 'Link không được để trống!',
            'status.required' => 'Status không được để trống!',
            'name.between' => 'Chuỗi không được bé hơn 5 và lớn hơn 100 ký tự!',
            'name.unique' => 'Name đã tồn tại!',
            'thumb.required' => 'Thumb không được để trống!',
            'thumb.mimes' => 'Định dạng file upload phải là jpeg,png,jpg,gif,svg',
            'thumb.max' => 'Dung lượng tối đa chỉ được :max',
        ];
    }
}
