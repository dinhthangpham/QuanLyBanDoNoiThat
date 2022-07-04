<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/Admin/MyCss/AdminLogin.css">
    <title>{{ $title }}</title>
   
</head>
<body>
   <div class="login_form">
    <div class="container_admin">
        <h1 class="title">{{ $title }}</h1>
        @include('Common.Toast')
        <form action="{{ route('login.store') }}" method="post">
               
            <div class="form_control margin_15px">
                <input  autocomplete="off" value="{{ $user }}"  type="text" class="input_form" name="txtAccount" placeholder="Tên tài khoản">
                {{-- <label for="" class="input_label">Tên tài khoản</label> --}}
            </div>
            <div class="form_control margin_15px">
                <input  type="password" value="{{ $password }}" class="input_form" name="txtPassword" placeholder="Mật khẩu">
                {{-- <label for="" class="input_label">Mật khẩu</label> --}}
            </div>
            <div class="container_admin-checked margin_15px">
                <input autocomplete="off" type="checkbox" name="ckoRemember" {{ $remember }} id=""> Nhớ mật khẩu
            </div>
            <Button type="submit" class='margin_15px' name="btnLogin">Login</Button>   
            {{-- <div class="register">
                No register? <a href="#">Create a new account.</a>    
            </div>      --}}
            @csrf 
        </form>
    </div>
   </div>
    
    
</body>
   
</html>