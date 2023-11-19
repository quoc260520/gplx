@extends('admin.layout')
@section('content')

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">Thêm Nhà Cung Cấp</a>
                <!-- Navigation links -->
            </div>
        </nav>
        <div class="container my-5 px-5">
            <div class="row">
                <div class="row">
                    <!-- Form to add a new question -->
                    <form method="POST" action="{{ route('post.supplier.action') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-lg-12 border-end">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên Nhà Cung Cấp<span
                                            class="text-red">(*)</span></label>
                                    <input type="name" class="form-control" id="name" name="name"
                                        value="{{ old('name') ?? '' }}"
                                        aria-required="Vui lòng điền email">
                                    @if ($errors->has('name'))
                                        <div class="mes-feedback">
                                            Tên không được để trống
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Địa Chỉ<span
                                            class="text-red">(*)</span></label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        value="{{ old('address') ?? '' }}">
                                    @if ($errors->has('address'))
                                        <div class="mes-feedback">
                                            Địa Chỉ không được để trống
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Số Điện Thoại<span
                                            class="text-red">(*)</span></label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ old('phone') ?? '' }}">
                                    @if ($errors->has('phone'))
                                        <div class="mes-feedback">
                                            Số điện thoại không được để trống
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-5 mb-5 text-center">
                            <button type="submit" class="btn btn-primary">Thêm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
    <script type="text/javascript" src="{{ URL::asset('dist/js/custom/users.js') }}"></script>
    <style>
        #avatar_pre {
            max-width: 220px;
            max-height: 220px;
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
