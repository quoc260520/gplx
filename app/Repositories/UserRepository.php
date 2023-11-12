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
    public function getAll($request)
    {
        $email = $request->email;
        $full_name = $request->full_name;
        $phone = $request->phone;
        $cccd = $request->cccd;

        $staffs = $this->model
            ::role(User::ROLE_STAFF)
            ->where('id', '<>', Auth::user()->id)
            ->when($email, function ($query, $email) {
                $query->where('email', 'like', ["%$email%"]);
            })
            ->when($full_name, function ($query, $full_name) {
                $query->where('author_id', 'like', ["%$full_name%"]);
            })
            ->when($phone, function ($query, $phone) {
                $query->where('phone', 'like', ["%$phone%"]);
            })
            ->when($cccd, function ($query, $cccd) {
                $query->where('cccd', ["%$cccd%"]);
            })
            ->orderByDesc('created_at')
            ->paginate(User::PAGINATE);
        return [$staffs, $email, $full_name, $phone, $cccd];
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
        if ($staff->image) {
            $this->deleteImage($staff->image);
        }
        return $staff->delete();
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