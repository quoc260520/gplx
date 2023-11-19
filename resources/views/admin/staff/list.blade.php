@extends('admin.layout')

@section('content')
    <nav class="navbar d-flex flex-wrap">
        <div class="container">
            <form action="{{ route('staff.list') }}" class="d-flex" method="GET">
                <input class="form-control me-2 mr-4" type="text" name="full_name" value="{{ $full_name ?? '' }}"
                    placeholder="Họ tên">
                <input class="form-control me-2 mr-4" type="number" name="phone" value="{{ $phone ?? '' }}"
                    placeholder="Số điện thoại">
                <input class="form-control me-2 mr-4" type="text" name="email" value="{{ $email ?? '' }}"
                    placeholder="Email">
                <input class="form-control me-2 mr-4" type="number" name="" value="{{ $cccd ?? '' }}"
                    placeholder="CCCD/CMND">
                <button class="btn btn-outline-success btn-sm" type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </nav>


    <div class="mt-5 ps-5 pe-5">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-striped border border-2">
                    <thead>
                        <tr>
                            <th style="width:5%;" scope="col">STT</th>
                            <th style="width:10%;" scope="col">Mã nhân viên</th>
                            <th style="width:15%" scope="col">Email</th>
                            <th style="width:15%" scope="col">Họ tên</th>
                            <th style="width:10%;" scope="col">Số điện thoại</th>
                            <th style="width:10%;" scope="col">CCCD/CMND</th>
                            <th style="width:25%" scope="col">Địa chỉ</th>
                            <th style="width:10%;" scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($staffs))
                            @foreach ($staffs as $index => $staff)
                                <tr>
                                    <th scope="row">{{ $index * $staffs->currentPage() + 1 }}</th>
                                    <td>{{ $staff->position_code ?? '' }}</td>
                                    <td>{{ $staff->email ?? '' }}</td>
                                    <td>{{ $staff->full_name ?? '' }}</td>
                                    <td>{{ $staff->phone ?? '' }}</td>
                                    <td>{{ $staff->cccd ?? '' }}</td>
                                    <td>{{ $staff->address ?? '' }}</td>
                                    <td class="">
                                        <a class="btn btn-danger btn-sm mr-3"
                                            href="{{ route('staff.delete', ['id' => $staff->id]) }}" title="Delete"
                                            onclick="confirmation(event)"><i class="fa fa-trash"></i></a>
                                        <a href="{{ route('staff.update', ['id' => $staff->id]) }}"
                                            class="btn btn-primary btn-sm" title="Update"><i class="fa fa-pen"></i></a>
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
            <div class="d-flex justify-content-center">{{ $staffs->withQueryString()->links() }}</div>
        </div>
    </div>

    <script type="text/javascript" src="{{ URL::asset('dist/js/custom/users.js') }}"></script>



@endsection
