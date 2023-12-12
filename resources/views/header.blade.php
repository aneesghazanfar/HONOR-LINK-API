<!-- header.blade.php -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <title>XTREEM DEMO</title>
    <link rel="stylesheet" href="https://demo.0c48udm537.com/css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="https://demo.0c48udm537.com/css/common.css?v=1702059537">
    <link rel="stylesheet" href="https://demo.0c48udm537.com/css/jquery-ui.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="https://demo.0c48udm537.com/js/jquery-ui.min.js"></script>
    <script src="https://demo.0c48udm537.com/js/jquery.mCustomScrollbar.min.js"></script>
    <script>
       
    </script>
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;
            padding: 1px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            margin: 0;
            font-size: 1.5em;
            font-weight: 700;
            line-height: 1;
            letter-spacing: -0.05em;
            color: #305bbb;
        }

        .header .money {
            color: #305bbb;
        }

        .header .logout {
            border: 0;
            border-radius: 4px;
            margin-left: 10px;
            padding: 5px;
            font-size: 0.9em;
            font-weight: 500;
            color: #305bbb;
            line-height: 1;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="header">
        <div>
            <h1>XTREEM DEMO</h1>
        </div>
        <div>
            <span class="money">￦ 0.00</span>
            <a class="logout"  href="{{ route('logout') }}"  onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><span class="material-icons">logout</span> Log-out</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
         
            
        </div>

    </div>
