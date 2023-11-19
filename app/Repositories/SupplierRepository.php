<?php

namespace App\Repositories;

use App\Models\Supplier;

class SupplierRepository
{
    protected $model;

    public function __construct(Supplier $model)
    {
        $this->model = $model;
    }

    public function getSupplier($request)
    {
        $name = $request->name;
        $supplier = $this->model->when($name, function ($query, $name) {
            $query->where("name", "like", ["%$name%"]);
        })
            ->orderByDesc('created_at')
            ->paginate(Supplier::PAGINATE);
        return [$supplier, $name];
    }

    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function createSupplier($request)
    {
        $this->model->create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone
        ]);
    }

    public function updateSupplier($request)
    {
        $this->model->where("id", $request->id)->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone
        ]);
    }

    public function deleteSupplier($id)
    {
        $this->model->where('id', $id)->delete();
    }
}
