<?php

namespace App\Http\Controllers;

use App\Models\DrivingLicense;
use App\Http\Requests\StoreDrivingLicenseRequest;
use App\Http\Requests\UpdateDrivingLicenseRequest;
use App\Models\Supplier;
use App\Models\User;
use App\Repositories\DrivingLicenseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DrivingLicenseController extends Controller
{
    protected $drivingLicenseRepository;
    public function __construct(DrivingLicenseRepository $drivingLicenseRepository)
    {
        $this->drivingLicenseRepository = $drivingLicenseRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        [$gplxs, $driving_licenses_code, $cccd, $kind] = $this->drivingLicenseRepository->getAll($request);
        $drivingLicenseKind = DrivingLicense::DRIVING_LICENSE_KIND;
        return view('admin.gplx.list')
            ->withGplxs($gplxs)
            ->withCccd($cccd)
            ->withDrivingLicenseCode($driving_licenses_code)
            ->withDrivingLicenseKind($drivingLicenseKind)
            ->withKind($kind);
    }

    /**
     * Show the form for creating a new resource.
     */
    function generateRandomCode($length = 12)
    {
        $characters = '0123456789';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

    public function create()
    {
        $codeRandom = $this->generateRandomCode();

        while (DrivingLicense::checkExistence($codeRandom)) {
            $codeRandom = $this->generateRandomCode();
        }
        $drivingLicenseKind = DrivingLicense::DRIVING_LICENSE_KIND;
        $users = User::role(User::ROLE_CLIENT)->get();
        $suppliers = Supplier::get();
        return view('admin.gplx.create')
            ->withDrivingLicenseKind($drivingLicenseKind)
            ->withUsers($users)
            ->withSuppliers($suppliers)
            ->withCodeRandom($codeRandom);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDrivingLicenseRequest $request)
    {
        try {
            $staff = $this->drivingLicenseRepository->create($request);
            if ($staff['flag'] === false) {
                return back()->withFlashDanger($staff['message']);
            }
            return back()->withFlashSuccess('Thêm giấy phép lái xe thành công');
        } catch (\Exception $e) {
            return back()->withFlashDanger('Đã có lỗi xảy ra');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $users = User::role(User::ROLE_CLIENT)->get();
        $suppliers = Supplier::get();
        $drivingLicenseKind = DrivingLicense::DRIVING_LICENSE_KIND;
        $gplx = $this->drivingLicenseRepository->getById($id);
        return view('admin.gplx.update')
            ->withGplx($gplx)
            ->withUsers($users)
            ->withSuppliers($suppliers)
            ->withDrivingLicenseKind($drivingLicenseKind);
    }
    public function showModal($id)
    {
        $gplx = $this->drivingLicenseRepository->getById($id);
        return [
            'gplx' => $gplx,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDrivingLicenseRequest $request, $id)
    {
        try {
            $staff = $this->drivingLicenseRepository->update($request, $id);
            if ($staff['flag'] === false) {
                return back()->withFlashDanger($staff['message']);
            }
            return back()->withFlashSuccess('Cập nhật giấy phép lái xe thành công');
        } catch (\Exception $e) {
            return back()->withFlashDanger('Đã có lỗi xảy ra');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->drivingLicenseRepository->gplxDelete($id);
            return back()->withFlashSuccess('Xóa thành công');
        } catch (\Exception $e) {
            Log::channel('daily')->error($e->getMessage());
            return back()->withFlashDanger('Đã có lỗi xảy ra');
        }
    }
}
