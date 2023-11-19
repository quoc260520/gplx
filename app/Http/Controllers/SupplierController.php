<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Repositories\SupplierRepository;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    protected $supplierRepository;
    public function __construct(SupplierRepository $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }
    public function getViewSupplier(Request $request) {
        [$supplier, $name] = $this->supplierRepository->getSupplier($request);
        return view("admin.supplier.list", ['suppliers'=> $supplier, "name" =>$name]);
    }
    public function getViewCreateSupplier() {
        return view("admin.supplier.create");
    }

    public function getViewUpdate (Request $request) {
        try {
           $Supplier = $this->supplierRepository->getById($request->id);
           return view("admin.supplier.update", ['supplier'=> $Supplier]);
        } catch (\Throwable $th) {
            return back()->withErrors('Đã có lỗi xảy ra!');
        }
    }

    public function createSupplier(Request $request) {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required'
        ]);
        try {
            $this->supplierRepository->createSupplier($request);
            return back()->withSuccess('Đã thêm nhà cung cấp!');
        } catch (\Throwable $th) {
            return back()->withErrors('Đã có lỗi xảy ra!');
        }
    }

    public function updateSupplier(Request $request) {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required'
        ]);
        try {
            $supplier = Supplier::where('id', $request->id);
            if(!$supplier) {
                return back()->withErrors('Nhà cung cấp này hiện tại không tồn tại, vui lòng kiểm tra lại dữ liệu!');
            }
            $this->supplierRepository->updateSupplier($request);
            return redirect()->route('get.supplier')->withSuccess('Cập nhật dữ liệu thành công');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->withErrors('Đã có lỗi xảy ra!');
        }
    }

    public function deleteSupplier(Request $request) {
        try {
            $supplier = Supplier::where('id', $request->id);
            if(!$supplier) {
                return back()->withErrors('Nhà cung cấp này hiện tại không tồn tại, vui lòng kiểm tra lại dữ liệu!');
            }
            $this->supplierRepository->deleteSupplier($request->id);
            return redirect()->route('/supplier')->withSuccess('Cập nhật dữ liệu thành công');
        } catch (\Throwable $th) {
            return back()->withErrors('Đã có lỗi xảy ra!');
        }
    }
}
