@extends('admin.layout')

@section('content')
    <nav class="navbar d-flex flex-wrap">
        <div class="container">
            <form action="{{ route('gplx.extend') }}" class="d-flex" method="GET">
                <input class="form-control me-2 mr-4" type="number" name="cccd" value="{{ $cccd ?? '' }}"
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
                                        <button type="button" onclick="showModalGplx({{ $gplx->id }})"
                                            class="btn btn-success btn-sm"><i class="fa fa-pen"></i> Gia hạn</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">GIA HẠN GPLX</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="" id="form_post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Khách hàng</label>
                            <input type="text" class="form-control" id="fullname_modal" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">CCCD</label>
                            <input type="text" class="form-control" id="cccd_modal" disabled>
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
                            <label for="recipient-name" class="col-form-label">Ngày hết hạn</label>
                            <input type="date" class="form-control" id="end_date_modal" name="end_date">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Gia hạn</button>
                    </div>
                </form>

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
                    $('#cccd_modal').val(data.user.cccd)
                    $('#code_modal').val(data.driving_licenses_code)
                    $('#kind_modal').val(data.driving_licenses_kind)
                    $('#supplier_modal').val(data.supplier.name)
                    $('#end_date_modal').val()
                    $('#form_post').attr('action', `/gplx/extend/${data.id}`);
                    $('#modalGplx').modal('show')
                },
                error: function(error) {
                    alert("Đã có lỗi xảy ra");
                }
            });
        }
    </script>

@endsection
