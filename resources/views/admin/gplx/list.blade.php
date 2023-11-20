@extends('admin.layout')

@section('content')
    <nav class="navbar d-flex flex-wrap">
        <div class="container">
            <form action="{{ route('gplx.list') }}" class="d-flex" method="GET">
                <input class="form-control me-2 mr-4" type="text" name="driving_licenses_code"
                    value="{{ $driving_licenses_code ?? '' }}" placeholder="Số GPLX">
                <input class="form-control me-2 mr-4" type="number" name="cccd" value="{{ $cccd ?? '' }}"
                    placeholder="CCCD/CMND">
                <select class="form-control form-select me-2 mr-4" name="kind">
                    <option value="">Tất cả</option>
                    @foreach ($drivingLicenseKind as $key => $value)
                        <option value="{{ $value }}" {{ $kind == $value ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
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
                            <th style="width:25%;" scope="col">Khách hàng</th>
                            <th style="width:20%" scope="col">Số GPLX</th>
                            <th style="width:10%" scope="col">Loại GPLX</th>
                            <th style="width:30%" scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($gplxs ?? []))
                            @foreach ($gplxs as $index => $gplx)
                                <tr>
                                    <th scope="row">{{ $index * $gplxs->currentPage() + 1 }}</th>
                                    <td>{{ $gplx->user->full_name ?? '' }}</td>
                                    <td>{{ $gplx->driving_licenses_code ?? '' }}</td>
                                    <td>{{ $gplx->driving_licenses_kind ?? '' }}</td>
                                    <td class="">
                                        @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('staff'))
                                            <a class="btn btn-danger btn-sm mr-3"
                                                href="{{ route('gplx.delete', ['id' => $gplx->id]) }}" title="Delete"
                                                onclick="confirmation(event)"><i class="fa fa-trash"></i> Xóa</a>
                                            <a href="{{ route('gplx.update', ['id' => $gplx->id]) }}"
                                                class="btn btn-primary btn-sm mr-3" title="Update"><i class="fa fa-pen"></i>
                                                Chỉnh Sửa</a>
                                        @endif
                                        <button type="button" onclick="showModalGplx({{ $gplx->id }})"
                                            class="btn btn-success btn-sm"><i class="fa fa-eye"></i> Xem</button>
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
            <div class="d-flex justify-content-center">{{ $gplxs->withQueryString()->links() }}</div>
        </div>
    </div>
    <div class="modal fade" id="modalGplx" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">THÔNG TIN GPLX</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Khách hàng</label>
                        <input type="text" class="form-control" id="fullname_modal" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Số GPLX</label>
                        <input type="text" class="form-control" id="code_modal" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Loại GPLX</label>
                        <input type="text" class="form-control" id="kind_modal" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Nhà cung cấp</label>
                        <input type="text" class="form-control" id="supplier_modal" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Ngày cấp</label>
                        <input type="text" class="form-control" id="start_date_modal" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Ngày hết hạn</label>
                        <input type="text" class="form-control" id="end_date_modal" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Nơi cấp</label>
                        <input type="text" class="form-control" id="issued_by_modal" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Trạng thái</label>
                        <input type="text" class="form-control" id="status_modal" disabled>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{ URL::asset('dist/js/custom/users.js') }}"></script>

    <script type="text/javascript">
        function formatDate(date) {
            var currentDate = new Date(date);
            var day = currentDate.getDate();
            var month = currentDate.getMonth() + 1; // Tháng bắt đầu từ 0
            var year = currentDate.getFullYear();
            var formattedDate = day + '-' + month + '-' + year;
            return formattedDate;

        }

        function showModalGplx(id) {
            $.ajax({
                type: "GET",
                url: `/gplx/show/${id}`,
                success: function(response) {
                    data = response.gplx;
                    $('#fullname_modal').val(data.user.full_name)
                    $('#code_modal').val(data.driving_licenses_code)
                    $('#kind_modal').val(data.driving_licenses_kind)
                    $('#supplier_modal').val(data.supplier.name)
                    $('#start_date_modal').val(formatDate(data.start_date))
                    $('#end_date_modal').val(data.end_date ? formatDate(data.end_date) : '---')
                    $('#issued_by_modal').val(data.issued_by)
                    $('#status_modal').val(data.status > 0 ? (data.status == 1 ? 'Còn hạn' : 'Hết hạn') :
                        'Vô thời hạn')
                    $('#modalGplx').modal('show')
                },
                error: function(error) {
                    alert("Đã có lỗi xảy ra");
                }
            });
        }
    </script>

@endsection
