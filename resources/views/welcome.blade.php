
<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
        <title>HONOR LiNK DEMO</title>
        <link rel="stylesheet" href="https://demo.0c48udm537.com/css/common.css?v=1702479447">
    </head>
    <body>
        <div class="loginWrap">
            <div>
                <h1>LOGIN</h1>
                <form name="swapfrom" id="swapfrom" method="post" autocomplete="off">
                    <div class="input">
                        <input type="text" name="userid" placeholder="ID" required class="ed" />
                    </div>
                    <div class="input">
                        <input type="password" name="userpass" placeholder="PASSWORD" required class="ed" />
                    </div>
                    <div><button type="submit" class="btnLogin">Login</button></div>
                    <!--div><a href="https://demo.0c48udm537.com/member/register" class="register">회원가입</a></div-->
                </form>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script>
        $(document).ready(function(){
            $('#swapfrom').submit(function(e){
                e.preventDefault();
                var f = document.swapfrom;
                if(!f.userid.value){
                    alert('아이디를 입력하세요.');
                    f.userid.focus();
                    return false;
                }
                if(!f.userpass.value){
                    alert('비밀번호를 입력하세요.');
                    f.userpass.focus();
                    return false;
                }
                $.ajax({
                    type: "post",
                    url: "https://demo.0c48udm537.com/login/loginCheck",
                    data: {
                        id: f.userid.value,
                        pass: f.userpass.value
                    },
                    dataType: "json",
                    async: false,
                    success: function(data){
                        console.log(data);
                        switch(data.status){
                            case 1: alert('아이디 또는 비밀번호가 공백이면 안됩니다.'); break;
                            case 2: alert('비밀번호가 일치하지 않습니다.'); break;
                            case 3: alert('존재하지 않는 계정입니다.'); break;
                            case 4: location.href = 'https://demo.0c48udm537.com'; break;
                        }
                        f.reset();
                        return false;
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        console.log(jqXHR, textStatus, errorThrown);
                    }
                });
            });
        });
        </script>
    </body>
</html>
