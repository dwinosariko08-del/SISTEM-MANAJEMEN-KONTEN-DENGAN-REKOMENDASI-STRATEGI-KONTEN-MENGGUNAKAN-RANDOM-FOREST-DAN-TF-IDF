<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register - {{ config('app.name') }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="icon" type="image/png" href="{{ asset('auth/images/icons/favicon.ico') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/vendor/animate/animate.css') }}">  
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/vendor/css-hamburgers/hamburgers.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/css/main.css') }}">

    <style>
        /* Variabel Warna Biru Primary */
        :root {
            --primary-color: #0D6EFD;
            --primary-hover: #0b5ed7;
        }

        .container-login100 {
            background: transparent !important;
            position: relative;
            z-index: 1;
            padding: 15px;
        }

        .limiter {
            position: relative;
            overflow: hidden;
            background-color: #000;
        }

        .limiter::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
            background-size: cover;
            background-position: center;
            animation: corporateSlideshow 20s infinite;
            filter: brightness(0.4);
        }

        @keyframes corporateSlideshow {
            0% { background-image: url('{{ asset('auth/images/gedung.jpg') }}'); }
            16% { background-image: url('{{ asset('auth/images/gedung1.jpg') }}'); }
            33% { background-image: url('{{ asset('auth/images/ruang1.jpg') }}'); }
            50% { background-image: url('{{ asset('auth/images/ruang2.jpeg') }}'); }
            66% { background-image: url('{{ asset('auth/images/ruang3.jpg') }}'); }
            83% { background-image: url('{{ asset('auth/images/ruang4.jpeg') }}'); }
            100% { background-image: url('{{ asset('auth/images/gedung.jpg') }}'); }
        }

        .wrap-login100 {
            width: 500px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(13, 110, 253, 0.3); /* Border tipis warna Biru */
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 40px 30px 40px !important;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.5);
        }

        .login100-pic {
            width: 100px !important;
            margin-bottom: 20px;
        }

        /* Perubahan Warna Teks & Aksen */
        .login100-form-title {
            color: var(--primary-color) !important;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }

        .txt1, .txt2 {
            color: #ffffff !important;
        }

        .txt2:hover {
            color: var(--primary-color) !important;
            text-decoration: none;
        }

        /* Tombol Register Biru */
        .login100-form-btn {
            background: var(--primary-color) !important;
            color: #000 !important;
            font-weight: 700;
            transition: all 0.4s;
        }

        .login100-form-btn:hover {
            background: #fff !important;
            color: #000 !important;
            box-shadow: 0 10px 20px rgba(13, 110, 253, 0.4);
        }

        /* Icon Input Warna Biru */
        .symbol-input100 i {
            color: var(--primary-color) !important;
        }

        .input100 {
            background: rgba(255, 255, 255, 0.9) !important;
        }

        .m-b-16 { margin-bottom: 16px; }
    </style>
</head>
<body>
    
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="{{ asset('auth/images/logo.png') }}" alt="Media Informatika Logo">
                </div>

                <form class="login100-form validate-form" method="POST" action="{{ route('register') }}">
                    @csrf

                    <span class="login100-form-title" style="padding-bottom: 25px;">
                        Create Account
                    </span>

                    <div class="wrap-input100 validate-input m-b-16" data-validate="Name is required">
                        <input class="input100" type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" required autofocus>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </span>
                    </div>
                    @if($errors->has('name'))
                        <p class="text-danger small p-l-10">{{ $errors->first('name') }}</p>
                    @endif

                    <div class="wrap-input100 validate-input m-b-16" data-validate="Valid email is required: ex@abc.xyz">
                        <input class="input100" type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>
                    @if($errors->has('email'))
                        <p class="text-danger small p-l-10">{{ $errors->first('email') }}</p>
                    @endif

                    <div class="wrap-input100 validate-input m-b-16" data-validate="Password is required">
                        <input class="input100" type="password" name="password" placeholder="Password" required>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>
                    @if($errors->has('password'))
                        <p class="text-danger small p-l-10">{{ $errors->first('password') }}</p>
                    @endif

                    <div class="wrap-input100 validate-input m-b-16" data-validate="Confirm Password is required">
                        <input class="input100" type="password" name="password_confirmation" placeholder="Confirm Password" required>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-refresh" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" type="submit">
                            Register
                        </button>
                    </div>

                    <div class="text-center p-t-40">
                        <a class="txt2" href="{{ route('login') }}">
                            Already registered? <span style="font-weight: bold; color: var(--primary-color);">Log in here</span>
                            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true" style="color: var(--primary-color);"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="{{ asset('auth/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('auth/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('auth/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('auth/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('auth/vendor/tilt/tilt.jquery.min.js') }}"></script>
    <script>
        $('.js-tilt').tilt({
            scale: 1.1
        })
    </script>
    <script src="{{ asset('auth/js/main.js') }}"></script>

</body>
</html>