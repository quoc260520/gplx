@extends('admin.layout')

@section('content')
    <div class="px-5 pt-5">
        <table class="table table-striped border border-2">
            <thead>
                <tr>
                    <th style="width:5%;" scope="col">STT</th>
                    <th style="width:25%;" scope="col">Tên</th>
                    <th style="width:25%" scope="col">Địa Chỉ</th>
                    <th style="width:25%" scope="col">Số Điện Thoại</th>
                    <th style="width:20%" scope="col">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @if (count($suppliers ?? []))
                    @foreach ($suppliers as $index => $supplier)
                        <tr>
                            <th scope="row">{{ $index * $suppliers->currentPage() + 1 }}</th>
                            <td>{{ $supplier->name ?? '' }}</td>
                            <td>{{ $supplier->address ?? '' }}</td>
                            <td>{{ $supplier->phone ?? '' }}</td>
                            <td class="d-flex">
                                <a href="{{ route('update.supplier.view', ['id' => $supplier->id]) }}"
                                    class="btn btn-primary btn-sm mr-3 d-flex align-items-center" title="Update"><i class="fa fa-pen"></i>
                                    update
                                </a>
                                <a href="{{ route('delete.supplier', ['id' => $supplier->id]) }}"
                                    onclick="confirmation(event)"
                                    class="btn btn-danger btn-sm mr-3 d-flex align-items-center" title="delete"><i class="fa fa-trash"></i>
                                    delete
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8" class="text-center">Danh sách trống</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">{{ $suppliers->withQueryString()->links() }}</div>

    <script type="text/javascript" src="{{ URL::asset('dist/js/custom/users.js') }}"></script>
@endsection
