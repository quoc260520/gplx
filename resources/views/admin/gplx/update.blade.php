@extends('admin.layout')
@section('content')
@push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @endpush

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">Cập nhật giấy phép lái xe</a>
                <!-- Navigation links -->
            </div>
        </nav>
        <div class="container my-5">
            <div class="row">
                <div class="row">
                    <!-- Form to add a new question -->
                    <form method="POST" action="{{ route('post.gplx.update', ['id' => $gplx->id]) }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <label for="user_id" class="form-label">Khách hàng<span
                                            class="text-red">(*)</span></label>
                                    <select class="form-select" name="user_id" id="gplx_user_id">
                                        @foreach ($users as $key => $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->full_name . '-' . $user->cccd }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('user_id'))
                                        <div class="mes-feedback">
                                            {{ $errors->first('user_id') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="supplier_id" class="form-label">Nhà cung cấp<span
                                            class="text-red">(*)</span></label>
                                    <select class="form-select" name="supplier_id" id="gplx_supplier_id">
                                        @foreach ($suppliers as $key => $suppliers)
                                            <option value="{{ $suppliers->id }}">
                                                {{ $suppliers->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('supplier_id'))
                                        <div class="mes-feedback">
                                            {{ $errors->first('supplier_id') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="kind" class="form-label">Loại GPLX<span
                                            class="text-red">(*)</span></label>
                                    <select class="form-select" name="kind" id="kind">
                                        @foreach ($drivingLicenseKind as $key => $kind)
                                            <option value="{{ $kind }}"
                                                {{ old('kind') == $kind || $gplx->driving_licenses_kind == $kind ? 'selected' : '' }}>
                                                {{ $kind }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('kind'))
                                        <div class="mes-feedback">
                                            {{ $errors->first('kind') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="driving_licenses_code" class="form-label">Mã GPLX<span
                                            class="text-red">(*)(12 số)</span></label>
                                    <input type="text" class="form-control" id="driving_licenses_code"
                                        name="driving_licenses_code"
                                        value="{{ old('driving_licenses_code') ?? $gplx->driving_licenses_code }}">
                                    @if ($errors->has('driving_licenses_code'))
                                        <div class="mes-feedback">
                                            {{ $errors->first('driving_licenses_code') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Ngày cấp<span
                                            class="text-red">(*)</span></label>
                                    <input type="date" class="form-control" id="start_date" name="start_date"
                                        value="{{ old('start_date') ?? date_format(date_create($gplx->start_date), 'Y-m-d') }}">
                                    @if ($errors->has('start_date'))
                                        <div class="mes-feedback">
                                            {{ $errors->first('start_date') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">Ngày hết hạn
                                        <span class="text-red">(*)</span>
                                    </label>
                                    <input type="date" class="form-control" id="end_date" name="end_date"
                                        value="{{ old('end_date') ?? date_format(date_create($gplx->end_date), 'Y-m-d') }}">
                                    @if ($errors->has('end_date'))
                                        <div class="mes-feedback">
                                            {{ $errors->first('end_date') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="issued_by" class="form-label">Nơi cấp<span
                                            class="text-red">(*)</span></label>
                                    <input type="text" class="form-control" id="issued_by" name="issued_by"
                                        value="{{ old('issued_by') ?? ($gplx->issued_by ?? '') }}">
                                    @if ($errors->has('issued_by'))
                                        <div class="mes-feedback">
                                            {{ $errors->first('issued_by') }}
                                        </div>
                                    @endif
                                </div>
                                                            <div class="mb-3">
                                    <label for="status" class="form-label">Trạng thái</label>
                                    <select class="form-select" name="status" id="status">
                                    <option value="0" {{ $gplx->status == 0 ? 'selected' : '' }}>Còn hạn</option>
                                        <option value="1" {{ $gplx->status == 1 ? 'selected' : '' }}>Hết hạn</option>
                                    </select>
                                    @if ($errors->has('status'))
                                        <div class="mes-feedback">
                                            {{ $errors->first('status') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-5 mb-5 text-center">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
    <script type="text/javascript" src="{{ URL::asset('dist/js/custom/users.js') }}"></script>
<script>
        $(document).ready(function() {
            $('#gplx_user_id').val({{ old('user_id') ?? $gplx->user_id }}).trigger('change');
            $("#gplx_supplier_id").val({{ old('supplier_id') ?? $gplx->supplier_id }}).trigger('change');
        });
    </script>
    <style>
        .select2-selection__rendered {
            line-height: 30px !important;
        }

        .select2-container .select2-selection--single {
            height: 40px !important;
        }

        .select2-selection__arrow {
            height: 40px !important;
        }

        .mes-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: .875em;
            color: var(--bs-danger-text);
        }
    </style>
@endsection
