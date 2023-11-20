@extends('admin.layout')

@section('content')
    <nav class="navbar d-flex flex-wrap">
        <div class="container">
            <form action="{{ route('client.list') }}" class="d-flex" method="GET">
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
            <div class="col-lg-12" style="overflow-x: auto; max-width: 80vw">
                <table class="table table-striped border border-2">
                    <thead>
                        <tr>
                            <th style="min-width: 30px;" scope="col">STT</th>
                            <th style="min-width: 200px;" scope="col">Email</th>
                            <th style="min-width: 200px;" scope="col">Họ tên</th>
                            <th style="min-width: 200px;" scope="col">Số điện thoại</th>
                            <th style="min-width: 100px;" scope="col">CCCD/CMND</th>
                            <th style="min-width: 100px;" scope="col">Địa chỉ</th>
                            <th style="min-width: 200px;" scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($clients))
                            @foreach ($clients as $index => $client)
                                <tr>
                                    <th scope="row">{{ $index * $clients->currentPage() + 1 }}</th>
                                    <td>{{ $client->email ?? '' }}</td>
                                    <td>{{ $client->full_name ?? '' }}</td>
                                    <td>{{ $client->phone ?? '' }}</td>
                                    <td>{{ $client->cccd ?? '' }}</td>
                                    <td>{{ $client->address ?? '' }}</td>
                                    <td class="d-flex align-items-center">
                                        <a class="btn btn-danger btn-sm mr-3"
                                            href="{{ route('client.delete', ['id' => $client->id]) }}" title="Delete"
                                            onclick="confirmation(event)"><i class="fa fa-trash"></i> Xóa</a>
                                        <a href="{{ route('client.update', ['id' => $client->id]) }}"
                                            class="btn btn-primary btn-sm" title="Update"><i class="fa fa-pen"></i> Chỉnh Sửa</a>
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
            <div class="d-flex justify-content-end">{{ $clients->withQueryString()->links() }}</div>
        </div>
    </div>

    <script type="text/javascript" src="{{ URL::asset('dist/js/custom/users.js') }}"></script>



@endsection
