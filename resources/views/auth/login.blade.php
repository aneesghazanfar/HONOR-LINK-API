
<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
        <title>HONOR LINK DEMO</title>
        <link rel="stylesheet" href="{{ asset('/css/common.css?v=1702479447') }}">
        <!-- <link rel="stylesheet" href="https://demo.0c48udm537.com/css/common.css?v=1702479447"> -->
    </head>
    <body>
        <div class="loginWrap">
            <div>
                <h1>LOGIN</h1>
                <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="input">
                        <input type="text" name="email"  id="email" placeholder="ID" required class="ed" />
                    </div>
                    <div class="input">
                        <input id="password" type="password" name="password" placeholder="PASSWORD" required class="ed" />
                    </div>
                    <div>
                        <button type="submit" class="btnLogin">Login</button></div>
                    <!--div><a href="https://demo.0c48udm537.com/member/register" class="register">회원가입</a></div-->
                </form>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>


        
    </body>
</html>
