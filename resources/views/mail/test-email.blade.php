<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
    <div>
        <div style="text-align: center">
            <h1>RESET PASSWORD</h1>
        </div>
        <div style="padding: 20px; border-top: 2px solid #444; border-bottom: 2px solid #444">
            <h3>Xin Chào {{ $name }}</h3>
            <span>
                Chúng tôi nhận được thông tin muốn thay đổi mật khẩu từ bạn
                <br />
                Nếu đúng là bạn hãy nhấp vào button bên dưới để thay đổi mật khẩu</span>
            <div class="d-flex justify-centent-center py-2 px-5 mt-3" style="background: 'red'">
                <br />
                <div style="text-align: center">
                    <a href={{ $url }}>
                        <button type="button" style="background: #FFC312; padding: 5px 10px; border-radius: 20px">Thay Đổi Mật Khẩu</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
<style>
    .container-mail {
        padding: 20px;
        border-top: 1px solid #444;
        border-bottom: 1px solid #444;
    }

    .login_btn {
        color: black;
        background-color: #FFC312;
    }
</style>

</html>
