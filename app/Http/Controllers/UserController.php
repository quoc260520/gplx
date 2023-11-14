<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaffRequest;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function staff(Request $request)
    {
        [$staffs, $email, $full_name, $phone, $cccd] = $this->userRepository->getAll($request);
        return view('admin.staff.list')
            ->withStaffs($staffs)
            ->withEmail($email)
            ->withFullName($full_name)
            ->withPhone($phone)
            ->withCccd($cccd);
    }
    public function getStaffCreate(Request $request)
    {
        return view('admin.staff.create');
    }
    public function staffCreate(StaffRequest $request)
    {
        try {
            $staff = $this->userRepository->createStaff($request);
            if ($staff['flag'] === false) {
                return back()->withFlashDanger($staff['message']);
            }
            return back()->withFlashSuccess('Thêm thành công');
        } catch (\Exception $e) {
            return back()->withFlashDanger('Đã có lỗi xảy ra');
        }
    }
    public function getStaffUpdate(Request $request, $id)
    {
        $staff = $this->userRepository->getById($id);
        return view('admin.staff.update')->withStaff($staff);
    }
    public function staffUpdate(Request $request, $id)
    {
        try {
            $staff = $this->userRepository->updateStaff($request, $id);
            if ($staff['flag'] === false) {
                return back()->withFlashDanger($staff['message']);
            }
            return back()->withFlashSuccess('Cập nhật thành công');
        } catch (\Exception $e) {
            return back()->withFlashDanger('Đã có lỗi xảy ra');
        }
    }
    public function staffDelete(Request $request, $id)
    {
        try {
            $this->userRepository->staffDelete($id);
            return back()->withFlashSuccess('Xóa thành công');
        } catch (\Exception $e) {
            return back()->withFlashDanger('Đã có lỗi xảy ra');
        }
    }
}
