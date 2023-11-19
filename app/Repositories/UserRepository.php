<?php

namespace App\Repositories;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UserRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }
    public function getAll($request, $role)
    {
        $email = $request->email;
        $full_name = $request->full_name;
        $phone = $request->phone;
        $cccd = $request->cccd;

        $users = $this->model
            ::role($role)
            ->where('id', '<>', Auth::user()->id)
            ->when($email, function ($query, $email) {
                $query->where('email', 'like', ["%$email%"]);
            })
            ->when($full_name, function ($query, $full_name) {
                $query->where('full_name', 'like', ["%$full_name%"]);
            })
            ->when($phone, function ($query, $phone) {
                $query->where('phone', 'like', ["%$phone%"]);
            })
            ->when($cccd, function ($query, $cccd) {
                $query->where('cccd', ["%$cccd%"]);
            })
            ->orderByDesc('created_at')
            ->paginate(User::PAGINATE);
        return [$users, $email, $full_name, $phone, $cccd];
    }
    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }
    public function createStaff($data)
    {
        try {
            $image = $data->file('image');
            if (is_file($image)) {
                $image = $this->uploadImage($image);
            }
            $user = $this->model->where('email', $data->email)->first();
            if ($user) {
                if ($user->hasRole(User::ROLE_STAFF)) {
                    return [
                        'flag' => false,
                        'message' => 'Email đã tồn tại',
                    ];
                } else {
                    $user->assignRole(User::ROLE_STAFF);
                    return [
                        'flag' => true,
                        'message' => 'Thêm nhân viên thành công',
                    ];
                }
            }
$checkUniquePhone = $data->phone ? $this->model->where('phone', $data->phone)->count() : 0;
            $checkUniqueCccd = $data->cccd ? $this->model->where('cccd', $data->cccd)->count() : 0;
            if ($checkUniquePhone > 0) {
                return [
                    'flag' => false,
                    'message' => 'Số điện thoại đã tồn tại',
                ];
            }
            if ($checkUniqueCccd > 0) {
                return [
                    'flag' => false,
                    'message' => 'CCCD/CMND đã tồn tại',
                ];
            }
            $staff = $this->model->create([
                'email' => $data->email,
                'password' => Hash::make($data->password),
                'position_code' => $data->position_code,
                'full_name' => $data->full_name,
                'address' => $data->address,
                'phone' => $data->phone,
                'cccd' => $data->cccd,
                'sex' => $data->sex,
                'image' => $image,
            ]);
            $staff->assignRole(User::ROLE_STAFF);
            return [
                'flag' => true,
                'message' => 'Thêm nhân viên thành công',
            ];
        } catch (\Exception $e) {
            $this->deleteImage($image);
            Log::channel('daily')->error('' . $e->getMessage());
            return [
                'flag' => false,
                'message' => 'Đã có lỗi xảy ra',
            ];
        }
    }
    public function updateStaff($data, $id)
    {
        try {
            $image = $data->file('image');
            if (is_file($image)) {
                $image = $this->uploadImage($image);
            }
            $user = $this->model
                ->where('email', $data->email)
                ->where('id', '<>', $id)
                ->first();
            if ($user) {
                if ($user->hasRole(User::ROLE_STAFF)) {
                    return [
                        'flag' => false,
                        'message' => 'Email đã tồn tại',
                    ];
                } else {
                    $user->assignRole(User::ROLE_STAFF);
                    return [
                        'flag' => true,
                        'message' => 'Cập nhật nhân viên thành công',
                    ];
                }
            }
$checkUniquePhone = $data->phone
                ? $this->model
                    ->where('phone', $data->phone)
                    ->where('id', '<>', $id)
                    ->count()
                : 0;
            $checkUniqueCccd = $data->cccd
                ? $this->model
                    ->where('cccd', $data->cccd)
                    ->where('id', '<>', $id)
                    ->count()
                : 0;
            if ($checkUniquePhone > 0) {
                return [
                    'flag' => false,
                    'message' => 'Số điện thoại đã tồn tại',
                ];
            }
            if ($checkUniqueCccd > 0) {
                return [
                    'flag' => false,
                    'message' => 'CCCD/CMND đã tồn tại',
                ];
            }
            $staff = $this->getById($id);
            $staff->update([
                'email' => $data->email,
                'password' => $data->password ? Hash::make($data->password) : $staff->password,
                'position_code' => $data->position_code,
                'full_name' => $data->full_name,
                'address' => $data->address,
                'phone' => $data->phone,
                'cccd' => $data->cccd,
                'sex' => $data->sex,
                'image' => $image ?? $data->image_old,
            ]);
            if (is_file($image) && $data->image_old) {
                $this->deleteImage($data->image_old);
            }
            return [
                'flag' => true,
                'message' => 'Cập nhật nhân viên thành công',
            ];
        } catch (\Exception $e) {
            $this->deleteImage($image);
            Log::channel('daily')->error('' . $e->getMessage());
            return [
                'flag' => false,
                'message' => 'Đã có lỗi xảy ra',
            ];
        }
    }
    public function staffDelete($id)
    {
        $staff = $this->getById($id);
        if ($staff->hasRole(User::ROLE_CLIENT)) {
            $staff->removeRole(User::ROLE_STAFF);
            return true;
        }
        if ($staff->image) {
            $this->deleteImage($staff->image);
        }
        return $staff->delete();
    }
    public function createClient($data)
    {
        try {
            $image = $data->file('image');
            if (is_file($image)) {
                $image = $this->uploadImage($image);
            }
            $user = $this->model->where('email', $data->email)->first();
            if ($user) {
                if ($user->hasRole(User::ROLE_CLIENT)) {
                    return [
                        'flag' => false,
                        'message' => 'Email đã tồn tại',
                    ];
                } else {
                    $user->assignRole(User::ROLE_CLIENT);
                    return [
                        'flag' => true,
                        'message' => 'Thêm khách hàng thành công',
                    ];
                }
            }
$checkUniquePhone = $data->phone ? $this->model->where('phone', $data->phone)->count() : 0;
            $checkUniqueCccd = $data->cccd ? $this->model->where('cccd', $data->cccd)->count() : 0;
            if ($checkUniquePhone > 0) {
                return [
                    'flag' => false,
                    'message' => 'Số điện thoại đã tồn tại',
                ];
            }
            if ($checkUniqueCccd > 0) {
                return [
                    'flag' => false,
                    'message' => 'CCCD/CMND đã tồn tại',
                ];
            }
            $staff = $this->model->create([
                'email' => $data->email,
                'password' => Hash::make($data->password),
                'full_name' => $data->full_name,
                'address' => $data->address,
                'phone' => $data->phone,
                'cccd' => $data->cccd,
                'sex' => $data->sex,
                'image' => $image,
            ]);
            $staff->assignRole(User::ROLE_CLIENT);
            return [
                'flag' => true,
                'message' => 'Thêm khách hàng thành công',
            ];
        } catch (\Exception $e) {
            $this->deleteImage($image);
            Log::channel('daily')->error('' . $e->getMessage());
            return [
                'flag' => false,
                'message' => 'Đã có lỗi xảy ra',
            ];
        }
    }
    public function updateClient($data, $id)
    {
        try {
            $image = $data->file('image');
            if (is_file($image)) {
                $image = $this->uploadImage($image);
            }
            $user = $this->model
                ->where('email', $data->email)
                ->where('id', '<>', $id)
                ->first();
            if ($user) {
                if ($user->hasRole(User::ROLE_CLIENT)) {
                    return [
                        'flag' => false,
                        'message' => 'Email đã tồn tại',
                    ];
                } else {
                    $user->assignRole(User::ROLE_CLIENT);
                    return [
                        'flag' => true,
                        'message' => 'Cập nhật khách hàng thành công',
                    ];
                }
            }
$checkUniquePhone = $data->phone
                ? $this->model
                    ->where('phone', $data->phone)
                    ->where('id', '<>', $id)
                    ->count()
                : 0;
            $checkUniqueCccd = $data->cccd
                ? $this->model
                    ->where('cccd', $data->cccd)
                    ->where('id', '<>', $id)
                    ->count()
                : 0;
            if ($checkUniquePhone > 0) {
                return [
                    'flag' => false,
                    'message' => 'Số điện thoại đã tồn tại',
                ];
            }
            if ($checkUniqueCccd > 0) {
                return [
                    'flag' => false,
                    'message' => 'CCCD/CMND đã tồn tại',
                ];
            }
            $staff = $this->getById($id);
            $staff->update([
                'email' => $data->email,
                'password' => $data->password ? Hash::make($data->password) : $staff->password,
                'full_name' => $data->full_name,
                'address' => $data->address,
                'phone' => $data->phone,
                'cccd' => $data->cccd,
                'sex' => $data->sex,
                'image' => $image ?? $data->image_old,
            ]);
            if (is_file($image) && $data->image_old) {
                $this->deleteImage($data->image_old);
            }
            return [
                'flag' => true,
                'message' => 'Cập nhật khách hàng thành công',
            ];
        } catch (\Exception $e) {
            $this->deleteImage($image);
            Log::channel('daily')->error('' . $e->getMessage());
            return [
                'flag' => false,
                'message' => 'Đã có lỗi xảy ra',
            ];
        }
    }
    public function clientDelete($id)
    {
        $client = $this->getById($id);
        if ($client->hasRole(User::ROLE_STAFF)) {
            $client->removeRole(User::ROLE_CLIENT);
            return true;
        }
        if ($client->image) {
            $this->deleteImage($client->image);
        }
        return $client->delete();
    }
    public function uploadImage($image)
    {
        $imageName = Str::random(6) . time() . '.' . $image->extension();
        Storage::disk('public')->put('avatar/' . $imageName, file_get_contents($image));
        return $imageName;
    }
    public function deleteImage($imageName)
    {
        return $imageName ? Storage::disk('public')->delete('avatar/' . $imageName) : '';
    }
}
