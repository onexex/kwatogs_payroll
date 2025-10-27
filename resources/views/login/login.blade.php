<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> -->

    <script src="https://unpkg.com/axios@0.27.0/dist/axios.min.js"></script>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', '') }}</title>

    <script src="{{ asset('js/jquery.dialog.js') }}" defer></script>
    <link href="{{ asset('css/jquery.dialog.css') }}" rel="stylesheet">
    <script src="{{ asset('js/login.js') }}" defer></script>
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            /* background-color: #f8f9fa; Light background color */
            background-color: #008080; /* Light background color */
        }
        .login-container {
            background-color: #ffffff;
            padding: 50px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 1000px;
        }
        /* .login-container h2 {
            margin-bottom: 35px;
            text-align: center;
            color: #343a40;
        } */

        .login-card-form {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 2px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 1000px;
        }
        .login-card-form h2 {
            margin-bottom: 35px;
            text-align: center;
            color: #343a40;
        }
        .form-label {
            font-weight: bold;
        }
        .btn-color {
            background-color: #008080;
            border-color: #008080;
            width: 100%;
            padding: 10px;
            font-size: 1.1rem;

        }
        .img-logo{
            background-image: url('../img/kwatogslogo.jpg');
            background-repeat: no-repeat;
            background-size: contain;
            background-position: center;
            width: auto;
            height: 500px;

        }
    </style>

</head>
<body >
     <div class="login-container">
        <div class="login-card">
            <div class="row">
                <div class="col-6">
                    <div class="login-card-form">
                        <h2>Login</h2>
                        <form id="frmlogin" action="#">
                            <div class="mb-3">
                                <input  type="email" name="username" class="form-control form-control-user mb-1" id="floatingInput" placeholder="name@example.com" value="{{ old('username')}}">
                                <label for="floatingInput">Email adresss </label>
                                <span class="text-danger small error-text username_error"></span>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="password" class="form-control form-control-user mb-3" id="floatingPassword" placeholder="Password">
                                <label for="floatingPassword">Password</label>
                                <span class="text-danger small error-text password_error"></span>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input">
                                <label class="form-check-label" for="rememberMe">Remember me</label>
                            </div>
                            <button type="submit" class="btn btn-outline-secondary btn-color text-white " id="btnLogin" >Login</button>
                            <div class="text-center mt-3">
                                <a href="#" class="text-decoration-none" style="color: #008080">Forgot Password?</a>
                            </div>
                            <div class="text-center mt-2">
                                Don't have an account? <a href="#" class="text-decoration-none" style="color: #008080">Sign Up</a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-6">
                    <div class="img-logo">

                    </div>
                </div>
            </div>

        </div>

    </div>
</body>
</html>
