<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaffRequest;
use App\Models\User;
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
        [$staffs, $email, $full_name, $phone, $cccd, $driving_licenses_code] = $this->userRepository->getAll($request, User::ROLE_STAFF);
        return view('admin.staff.list')
            ->withStaffs($staffs)
            ->withEmail($email)
            ->withFullName($full_name)
            ->withPhone($phone)
            ->withCccd($cccd)
            ->withDrivingLicensesCode($driving_licenses_code);
    }
    public function client(Request $request)
    {
        [$clients, $email, $full_name, $phone, $cccd, $driving_licenses_code] = $this->userRepository->getAll($request, User::ROLE_CLIENT);
        return view('admin.client.list')
            ->withClients($clients)
            ->withEmail($email)
            ->withFullName($full_name)
            ->withPhone($phone)
            ->withCccd($cccd)
            ->withDrivingLicensesCode($driving_licenses_code);
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
    public function staffUpdate(StaffRequest $request, $id)
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
    public function getClientCreate(Request $request)
    {
        return view('admin.client.create');
    }
    public function clientCreate(StaffRequest $request)
    {
        try {
            $staff = $this->userRepository->createClient($request);
            if ($staff['flag'] === false) {
                return back()->withFlashDanger($staff['message']);
            }
            return back()->withFlashSuccess('Thêm thành công');
        } catch (\Exception $e) {
            return back()->withFlashDanger('Đã có lỗi xảy ra');
        }
    }
    public function getClientUpdate($id)
    {
        $client = $this->userRepository->getById($id);
        return view('admin.client.update')->withClient($client);
    }
    public function clientUpdate(StaffRequest $request, $id)
    {
        try {
            $client = $this->userRepository->updateClient($request, $id);
            if ($client['flag'] === false) {
                return back()->withFlashDanger($client['message']);
            }
            return back()->withFlashSuccess('Cập nhật thành công');
        } catch (\Exception $e) {
            return back()->withFlashDanger('Đã có lỗi xảy ra');
        }
    }
    public function clientDelete($id)
    {
        try {
            $this->userRepository->clientDelete($id);
            return back()->withFlashSuccess('Xóa thành công');
        } catch (\Exception $e) {
            return back()->withFlashDanger('Đã có lỗi xảy ra');
        }
    }
}
