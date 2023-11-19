@extends('admin.layout')
@section('content')

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">Cập nhật nhân viên</a>
                <!-- Navigation links -->
            </div>
        </nav>
        <div class="container my-5">
            <div class="row">
                <div class="row">
                    <!-- Form to add a new question -->
                    <form method="POST" action="{{ route('post.staff.update', ['id' => $staff->id]) }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-lg-8 border-end">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email<span class="text-red">(*)</span></label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email') ? old('email') : $staff->email }}"
                                        placeholder="name@example.com" aria-required="Vui lòng điền email">
                                    @if ($errors->has('email'))
                                        <div class="mes-feedback">
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Mật khẩu<span
                                            class="text-red">(*)</span></label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        autocomplete="new-password">
                                    @if ($errors->has('password'))
                                        <div class="mes-feedback">
                                            {{ $errors->first('password') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="position_code" class="form-label">Mã chức vụ</label>
                                    <input type="text" class="form-control" id="position_code" name="position_code"
                                        value="{{ old('position_code') ? old('position_code') : $staff->position_code ?? '' }}">
                                    @if ($errors->has('position_code'))
                                        <div class="mes-feedback">
                                            {{ $errors->first('position_code') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="full_name" class="form-label">Họ tên<span
                                            class="text-red">(*)</span></label>
                                    <input type="text" class="form-control" id="full_name" name="full_name"
                                        value="{{ old('full_name') ? old('full_name') : $staff->full_name ?? '' }}">
                                    @if ($errors->has('full_name'))
                                        <div class="mes-feedback">
                                            {{ $errors->first('full_name') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Địa chỉ</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        value="{{ old('address') ? old('address') : $staff->address ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Số điện thoại</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        pattern="[0-9.]+" maxlength="11"
                                        value="{{ old('phone') ? old('phone') : $staff->phone ?? '' }}">
                                    @if ($errors->has('phone'))
                                        <div class="mes-feedback">
                                            {{ $errors->first('phone') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="cccd" class="form-label">CCCD/CMND</label>
                                    <input type="number" class="form-control" id="cccd" name="cccd" pattern="\d*"
                                        maxlength="12" value="{{ old('cccd') ? old('cccd') : $staff->cccd ?? '' }}">
                                    @if ($errors->has('cccd'))
                                        <div class="mes-feedback">
                                            {{ $errors->first('cccd') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="questionType" class="form-label">Giới tính</label>
                                    <select class="form-select" id="questionType" name="sex">
                                        <option value="0"{{ old('sex') ? (old('sex') == 0 ? 'selected' : '') : '' }}>
                                            Nam
                                        </option>
                                        <option value="1"{{ old('sex') ? (old('sex') == 1 ? 'selected' : '') : '' }}>
                                            Nữ
                                        </option>
                                    </select>
                                    @if ($errors->has('sex'))
                                        <div class="mes-feedback">
                                            {{ $errors->first('sex') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <img src="{{ $staff->image ? asset('storage/avatar/' . $staff->image) : asset('/dist/img/avatar.png') }}"
                                        class="rounded mx-auto d-block" alt="avatar" id="avatar_pre">
                                </div>
                                <div class="mb-3">
                                    <label for="questionImage" class="form-label">Hình ảnh</label>
                                    <input type="file" class="form-control" id="image_staff" name="image"
                                        accept="image/*" width="200" height="200">
                                    <input type="hidden" class="form-control" name="image_old"
                                        value="{{ $staff->image }}">
                                    @if ($errors->has('image'))
                                        <div class="mes-feedback">
                                            {{ $errors->first('image') }}
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
