<?php

namespace App\Http\Requests;

use App\Models\DrivingLicense;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDrivingLicenseRequest extends FormRequest
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
            'user_id' => 'required|numeric|exists:users,id',
            'supplier_id' => 'required|numeric|exists:suppliers,id',
            'kind' => ['required', Rule::in(DrivingLicense::DRIVING_LICENSE_KIND)],
            'driving_licenses_code' => 'required|numeric|regex:/^([0-9\s\-\+\(\)]*)$/|digits:12',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'issued_by' => 'required|string',
            'status' => 'required|integer|in:0,1',
        ];
    }
    public function attributes(): array
    {
        return [
            'user_id' => 'khách hàng',
            'supplier_id' => 'nhà cung cấp',
            'kind' => 'loại giấy phép lái xe',
            'driving_licenses_code' => 'số giấy phép lái xe',
            'start_date' => 'ngày cấp',
            'end_date' => 'ngày hết hạn',
            'issued_by' => 'nơi cấp',
            'status' => 'trạng thái',
        ];
    }
}
