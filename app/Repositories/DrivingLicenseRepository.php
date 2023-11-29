<?php

namespace App\Repositories;
use Illuminate\Support\Str;
use App\Models\DrivingLicense;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class DrivingLicenseRepository
{
    protected $model;

    public function __construct(DrivingLicense $model)
    {
        $this->model = $model;
    }
    public function getAll($request)
    {
        $driving_licenses_code = $request->driving_licenses_code;
        $cccd = $request->cccd;
        $kind = $request->kind;

        $gplx = $this->model
            ->when(Auth::user()->hasRole(User::ROLE_CLIENT) && !(Auth::user()->hasRole(User::ROLE_ADMIN) || Auth::user()->hasRole(User::ROLE_STAFF)), function ($query) {
                $query->where('user_id', Auth::user()->id);
            })
            ->when($driving_licenses_code, function ($query, $driving_licenses_code) {
                $query->where('driving_licenses_code', 'like', ["%$driving_licenses_code%"]);
            })
            ->when($kind, function ($query, $kind) {
                $query->where('driving_licenses_kind', ["$kind"]);
            })
            ->when($cccd, function ($query, $cccd) {
                $query->whereHas('user', function (Builder $q) use ($cccd) {
                    $q->where('cccd', 'like', ["%$cccd%"]);
                });
            })
            ->with('user')
            ->orderByDesc('created_at')
            ->paginate(20);
        return [$gplx, $driving_licenses_code, $cccd, $kind];
    }
    public function getById($id)
    {
        return $this->model->with(['user', 'supplier'])->findOrFail($id);
    }

    public function create($data)
    {
        try {
            $countGplx = $this->model
                ->where('status', DrivingLicense::STATUS_ACTIVE)
                ->where('status', DrivingLicense::STATUS_UNLIMITED)
                ->where(function ($query)  {
                    $query->whereDate('end_date', '>', Carbon::now())->orWhereNull('end_date');
                })
                ->where('user_id', $data['user_id'])
                ->where(function ($query) use ($data) {
                    $query->where('driving_licenses_code', $data['driving_licenses_code'])->orWhere('driving_licenses_kind', $data['kind']);
                })
                ->count();

            $countGplxAll = $this->model
            ->where('status', DrivingLicense::STATUS_ACTIVE)
            ->where('status', DrivingLicense::STATUS_UNLIMITED)
            ->where(function ($query)  {
                $query->whereDate('end_date', '>', Carbon::now())->orWhereNull('end_date');
            })
                ->where('driving_licenses_code', $data['driving_licenses_code'])
                ->where('driving_licenses_kind', $data['kind'])
                ->where('user_id', '<>', $data['user_id'])
                ->count();
            if ($countGplx > 0 || $countGplxAll > 0) {
                return [
                    'flag' => false,
                    'message' => 'Giấy phép lái xe đã tồn tại',
                ];
            }
            $gplx = $this->model->create([
                'user_id' => $data->user_id,
                'supplier_id' => $data->supplier_id,
                'driving_licenses_kind' => $data->kind,
                'driving_licenses_code' => $data->driving_licenses_code,
                'start_date' => $data->start_date,
                'end_date' => $data->end_date,
                'issued_by' => $data->issued_by,
                'status' => $data->status,
            ]);
            return [
                'flag' => true,
                'message' => 'Thêm giấy phép lái xe thành công',
            ];
        } catch (\Exception $e) {
            Log::channel('daily')->error('' . $e->getMessage());
            return [
                'flag' => false,
                'message' => 'Đã có lỗi xảy ra',
            ];
        }
    }
    public function update($data, $id)
    {
        try {
            $drivingLicense = $this->getById($id);

            $countGplx = $this->model
            ->where('status', DrivingLicense::STATUS_ACTIVE)
            ->where('status', DrivingLicense::STATUS_UNLIMITED)
            ->where(function ($query) {
                $query->whereDate('end_date', '>', Carbon::now())->orWhereNull('end_date');
            })
                ->where('user_id', $data['user_id'])
                ->where('id', '<>', $id)
                ->where(function ($query) use ($data) {
                    $query->where('driving_licenses_code', $data['driving_licenses_code'])->orWhere('driving_licenses_kind', $data['kind']);
                })
                ->count();

            $countGplxAll = $this->model
            ->where('status', DrivingLicense::STATUS_ACTIVE)
            ->where('status', DrivingLicense::STATUS_UNLIMITED)
            ->where(function ($query)  {
                $query->whereDate('end_date', '>', Carbon::now())->orWhereNull('end_date');
            })
                ->where('driving_licenses_code', $data['driving_licenses_code'])
                ->where('user_id', '<>', $data['user_id'])
                ->count();
            if ($countGplx > 0 || $countGplxAll > 0) {
                return [
                    'flag' => false,
                    'message' => 'Giấy phép lái xe đã tồn tại',
                ];
            }
            $gplx = $drivingLicense->update([
                'user_id' => $data->user_id ?? $drivingLicense->user_id,
                'supplier_id' => $data->supplier_id ?? $drivingLicense->supplier_id,
                'driving_licenses_kind' => $data->kind ?? $drivingLicense->kind,
                'driving_licenses_code' => $data->driving_licenses_code ?? $drivingLicense->driving_licenses_code,
                'start_date' => $data->start_date ?? $drivingLicense->start_date,
                'end_date' => $data->end_date ?? $drivingLicense->end_date,
                'issued_by' => $data->issued_by ?? $drivingLicense->issued_by,
                'status' => $data->status ?? $drivingLicense->status,
            ]);
            return [
                'flag' => true,
                'message' => 'Cập nhật giấy phép lái xe thành công',
            ];
        } catch (\Exception $e) {
            Log::channel('daily')->error('' . $e->getMessage());
            return [
                'flag' => false,
                'message' => 'Đã có lỗi xảy ra',
            ];
        }
    }

    public function gplxDelete($id)
    {
        $gplx = $this->getById($id);
        return $gplx->delete();
    }
    public function getExtend($request) {
        $cccd = $request->cccd;
        $gplx = $this->model
        ->where('status', DrivingLicense::STATUS_DEACTIVE)
        ->orWhere('end_date','<', Carbon::now())
        ->when($cccd, function ($query, $cccd) {
            $query->whereHas('user', function (Builder $q) use ($cccd) {
                $q->where('cccd', 'like', ["%$cccd%"]);
            });
        })
        ->with('user')
        ->orderByDesc('created_at')
        ->paginate(20);
        return [$cccd, $gplx];
    }
    public function postExtend($data, $id) {
        $drivingLicense = $this->getById($id);
        $gplx = $drivingLicense->update([
            'end_date' => $data->end_date,
            'status' => DrivingLicense::STATUS_ACTIVE,
        ]);
        return $gplx;
    }
}
