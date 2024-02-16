<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
        <title>XTREEM DEMO</title>
        <link rel="stylesheet" href="{{ asset('/css/jquery.mCustomScrollbar.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/common.css?v=1702489985') }}">
        <link rel="stylesheet" href="{{ asset('/css/jquery-ui.min.css') }}">
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script src="{{ asset('/js/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('/js/jquery.mCustomScrollbar.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>
        <script>
        </script>

    </head>
<body>
<div class="header">
        <div>
            <h1>XTREEM DEMO</h1>
        </div>
        <div>
            <?php
use Illuminate\Support\Facades\Http;

$response = Http::withHeaders([
    'accept' => 'application/json',
    'Authorization' => 'Bearer TgeQK2POExchRm2FoWNHeTHjS6LlseeTDwwxjcsp',
])->get('https://api.honorlink.org/api/user?username='.Auth::user()->email);
                if($response->json() != null)
                $balance = $response->json()['balance'];
            else
                $balance = 0;
            // dd($response->json()['balance']);
            ?>
            <span class="money">￦ {{ $balance }}</span>
            <a class="logout" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                     <span class="material-icons">logout</span>
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>

        </div>
    </div>
</body>
