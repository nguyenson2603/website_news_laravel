<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    private $table = 'user';
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
        $task = $this->task;

        $valAvatar = '';
        $valUsername = '';
        $valEmail = '';
        $valPassword = '';
        $valLevel = '';
        $valStatus = '';
        $valFullname = '';

        switch ($task) {
            case 'add':
                $valAvatar = "bail|required|mimes:jpeg,png,jpg,gif,svg|max:2048";
                $valUsername = "bail|required|between:5,100|unique:{$this->table},username";
                $valEmail = "bail|required|email|unique:{$this->table},email";
                $valPassword = "bail|required|between:5,10|confirmed";
                $valLevel = "bail|required";
                $valStatus = "bail|required";
                $valFullname = "bail|required|min:5";
                break;
            case 'edit':
                $valUsername = "bail|required|between:5,100|unique:{$this->table},username,{$id}";
                $valFullname = "bail|required|min:5";
                $valAvatar = 'bail|mimes:jpeg,png,jpg,gif,svg|max:2048';
                $valStatus = "bail|required";
                $valEmail = "bail|required|email|unique:{$this->table},email,{$id}";
                break;
            case 'change-password':
                $valPassword = "bail|required|between:5,10|confirmed";
                break;
            case 'change-level':
                $valLevel = "bail|required";
                break;
            default:
                # code...
                break;
        }

        // $valAvatar = 'bail|required|mimes:jpeg,png,jpg,gif,svg|max:2048';
        // $valUsername = "bail|required|between:5,100|unique:{$this->table},username";
        // $valEmail = "bail|required|email|unique:{$this->table},email";
        // $valPassword = 'bail|required|between:5,10|confirmed';
        // if (!empty($id)) {
        //     $valAvatar = 'bail|mimes:jpeg,png,jpg,gif,svg|max:2048';
        //     $valUsername .= ",$id";
        //     $valEmail .= ",$id";
        // }
        return [
            'username' => $valUsername,
            'email' => $valEmail,
            'fullname' => $valFullname,
            'password' => $valPassword,
            'status' => $valStatus,
            'level' => $valLevel,
            'avatar' => $valAvatar,
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Username không được để trống!',
            'password.required' => 'Password không được để trống!',
            'password.between' => 'Password không được bé hơn 5 và lớn hơn 10 ký tự!',
            'password.confirmed' => 'Nhập lại password không trùng khớp!',
            'email.required' => 'Email không được để trống!',
            'fullname.required' => 'Fullname không được để trống!',
            'fullname.min' => 'Độ dài tối thiểu là 5 ký tự!',
            'email.email' => 'Định dạng email không hợp lệ',
            'status.required' => 'Status không được để trống!',
            'level.required' => 'Level không được để trống!',
            'username.between' => 'Chuỗi không được bé hơn 5 và lớn hơn 100 ký tự!',
            'username.unique' => 'Username đã tồn tại!',
            'avatar.required' => 'Avatar không được để trống!',
            'avatar.mimes' => 'Định dạng file upload phải là jpeg,png,jpg,gif,svg',
            'avatar.max' => 'Dung lượng tối đa chỉ được :max',
        ];
    }
}
