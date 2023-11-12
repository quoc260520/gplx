<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "email" => "required|email",
            "password" => "required|string|min:6|max:8",
            "position_code" => "nullable|string",
            "full_name" => "required|string",
            "address" => "nullable|string",
            "phone" => "nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10",
            "cccd" => "nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:12|max:12",
            "sex" => "nullable|in:0,1",
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
    public function attributes(): array
    {
        return [
            "email" => "email",
            "password" => "Mật khẩu",
            "position_code" => "Mã nhân viên",
            "full_name" => "Họ tên",
            "address" => "Địa chỉ",
            "phone" => "Số điện thoại",
            "cccd" => "Số CCCD/CMND",
            "sex" => "Giới tính",
            "image" => "Ảnh"
        ];
    }
    public function messages(): array
    {
        return [];
    }
}
