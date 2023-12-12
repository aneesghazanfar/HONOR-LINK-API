<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>Login Page</title>
    <style>
        body {
            background: #efefef;
            color: #333;
            font-family: 'Arial', sans-serif;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .card {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 400px; /* Fixed width for the card */
            margin-top: 5vh; /* Reduced margin for better placement on smaller screens */
        }

        .card-header {
            color: #305BBB;
            font-weight: bold;
            font-size: 2em;
        }

        label {
            color: #3498db;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #3498db;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        .btn-primary {
            background-color: #3498db;
            color: #fff;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #1f618d;
        }

        .form-check-input {
            margin-top: 5px;
        }

        .btn-link {
            color: #3498db;
        }

        /* Additional styling for the login button */
        .btnLogin {
            background-color: #a6d0ff;
            color: #305BBB;
            font-size: 15.84px;
            font-family: 'Spoqa Han Sans', sans-serif;
            margin: 20px 0 0;
            padding: 12px 0;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btnLogin:hover {
            background-color: #85b8e4;
        }

        /* Accessibility features */
        .btnLogin {
            contrast: 3.91;
        }

        .btnLogin:focus {
            outline: none;
            box-shadow: 0 0 0 2px #305BBB;
        }

        /* Responsive button */
        .responsive-btn {
            background-color: #a6d0ff;
            color: #305BBB;
            font-size: 15.84px;
            font-family: 'Spoqa Han Sans', sans-serif;
            margin: 20px 0 0;
            padding: 12px 0;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 50%; /* Full width */
            font-weight: bold;
        }

        .responsive-btn:hover {
            background-color: #85b8e4;
        }

        /* Media Query for responsiveness */
        @media (max-width: 576px) {
            .card {
                width: 90%; /* Adjusted width for better responsiveness on smaller screens */
                margin-top: 2vh; /* Further reduced margin for better placement on smaller screens */
            }
        }
    </style>
</head>




<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('LOGIN') }}</div>
                <BR></BR>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <!-- <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('User Name') }}</label> -->

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder='ID'>

                                <!-- @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror -->
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end"></label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder='PASSWORD'>
                                <br>
                                <br>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        

                        <!-- <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div> -->

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="responsive-btn">
                                    {{ __('Login') }}
                                </button>

                                <!-- @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

