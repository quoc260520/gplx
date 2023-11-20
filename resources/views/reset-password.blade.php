<!DOCTYPE html>
<html lang="en">

<head>

    <head>
        <title>Reset Password</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
            integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
            integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    </head>
</head>

<body>
    @if ($errors->any())
        <div class="position-fixed justify-content-center top-0 toast" id="notification">
            <span class="toast-content bg-danger">{{ $errors->first() }}</span>
        </div>
    @endif
    @if ($success ?? '')
        <div class="position-fixed justify-content-center top-0 toast" id="notification">
            <span class="toast-content bg-success">{{ $success }}</span>
        </div>
    @endif
    <div class="container">
        <div class="d-flex justify-content-center h-100">
            <div class="card">
                <div class="card-header text-center font-weight-bold">
                    <h3>Reset Mật Khẩu</h3>
                </div>
                <div class="card-body">
                    <form accept="{{ route('post.reset') }}" method="post">
                        @csrf
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" class="form-control" placeholder="Mật khẩu" name="password">
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" class="form-control" placeholder="Nhập lại password"
                                name="password_confirmation">
                        </div>
                        <input type="hidden" value={{ $token }} name="token">
                        <div class="text-center">
                            <div class="form-group">
                                <input type="submit" value="Đặt Lại Mật Khẩu" class="btn login_btn">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<style>
    /* Made with love by Mutiullah Samim*/

    @import url('https://fonts.googleapis.com/css?family=Numans');

    html,
    body {
        background-image: url('/dist/img/background.png');
        background-size: cover;
        background-repeat: no-repeat;
        height: 100%;
        font-family: 'Numans', sans-serif;
    }

    .toast {
        left: 0;
        right: 0;
        display: flex;
    }

    .toast-content {
        padding: 10px 40px;
        margin-top: 20px;
        border-radius: 20px;
        color: white;
        animation: hiden_toast ease-in-out 5s;
    }

    @keyframes hiden_toast {
        from {
            opacity: 1;
        }

        to {
            opacity: 0.4;
        }
    }

    .container {
        height: 100%;
        align-content: center;
    }

    .card {
        margin-top: auto;
        margin-bottom: auto;
        width: 400px;
        background-color: rgba(0, 0, 0, 0.5) !important;
    }

    .social_icon span {
        font-size: 60px;
        margin-left: 10px;
        color: #FFC312;
    }

    .social_icon span:hover {
        color: white;
        cursor: pointer;
    }

    .card-header h3 {
        color: white;
    }

    .social_icon {
        position: absolute;
        right: 20px;
        top: -45px;
    }

    .input-group-prepend span {
        width: 50px;
        background-color: #FFC312;
        color: black;
        border: 0 !important;
    }

    input:focus {
        outline: 0 0 0 0 !important;
        box-shadow: 0 0 0 0 !important;

    }

    .remember {
        color: white;
    }

    .remember input {
        width: 20px;
        height: 20px;
        margin-left: 15px;
        margin-right: 5px;
    }

    .login_btn {
        color: black;
        background-color: #FFC312;
    }

    .login_btn:hover {
        color: black;
        background-color: white;
    }

    .links {
        color: white;
    }

    .links a {
        margin-left: 4px;
    }

    .h-50 {
        height: 50px !important;
    }
</style>

</html>
