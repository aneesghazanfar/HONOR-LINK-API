@include('header')
@include('side-bar')

<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <style>
         .container {
            margin-top: 1.5cm;
            margin-left: 210px; /* Adjust based on your sidebar width */
            padding: 2px;
            background-color: #fff;
            transition: margin-left 0.3s; /* Add smooth transition for better user experience */
        }

        .content {
           /* Adjust the width based on your design */
        }

        /* Add media query to adjust container margin for smaller screens */
        @media (max-width: 768px) {
            .container {
                margin-left: 0; /* Close the sidebar on smaller screens */
            }
        }

        h2 {
            display: inline-block;
            margin: 0 0 10px;
            font-size: 2em;
            letter-spacing: -0.05em;
            color: #222;
        }

        .content ul.main {
            display: block;
            font-size: 1.2em;
            color: #000;
        }

        .gameList dt {
            display: block;
            font-size: 1.2em;
            color: #000;
        }

        .gameList dd {
            padding-left: 20px;
        }

        .gameUnit {
            list-style: none;
            padding: 0;
        }

        .gameUnit li {
            display: inline-block;
            margin-right: 10px;
        }

        .gameUnit a {
            text-decoration: none;
            color: #000;
        }

        .imgWrap img {
            max-width: 100%;
            height: auto;
        }

        .title {
            margin-top: 5px;
            font-weight: 500;
            font-size: 1.2em;
        }

        .subtitle {
            font-size: 1em;
            color: #666;
        }

        .vendorList {
            list-style: none;
            padding: 0;
            cursor: pointer;
        }

        .vendorList li {
            margin-bottom: 10px;
            font-size: 1.2em;
            color: #000;
        }

        .gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .vendor-content {
            width: 100%;
        }

        .secondDivContent {
            text-align: center;
            padding: 20px;
            background-color: #f0f0f0;
        }

        .secondDivContent .gameUnit {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around; /* Adjust as needed */
        }

        .secondDivContent .gameUnit div {
            width: 100%; /* Use full width within the Bootstrap column */
            box-sizing: border-box;
            margin-bottom: 20px;
            text-align: center;
        }

        .secondDivContent img {
            max-width: 100%;
            height: auto;
            max-height: 100px; /* Set a max height for the images */
        }

        .secondDivContent .title {
            margin-top: 5px;
            font-weight: 500;
            font-size: 1.2em;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="content">
        <h2><span class="material-icons">subtitles</span> GAME LIST</h2>
        @foreach ($games as $vendor => $game)
            <div class="row">
                <dl class="gameList col-12" data-vd="live-inplay">
                    <dt class="col-12"><a href="#REAL">{{ $vendor }} <span>1</span></a></dt>
                    <dd class="secondDiv col-12" style="display: none;">
                        <!-- Content of the second div goes here -->
                        <div class="secondDivContent">
                            <div class="gameUnit">
                                @foreach($game as $key => $value)
                                    <div class="col-md-4">
                                        <img src="{{ $value['thumbnail'] }}" alt="Random Image" onerror="errorImg($(this));">
                                        <div class="title">{{ $value['title'] }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </dd>
                </dl>
            </div>
        @endforeach
    </div>
</div>

<div id="overlayer"></div>
<div id="overlayer02"></div>
<div class="winAlert">
    <div class="body"></div>
    <div class="bottom"></div>
</div>
<div class="delayLayer">
    <div>
        <div></div>
    </div>
</div>

<iframe name="hiddenframe" class="hiddenframe"></iframe>

<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
<script src="https://demo.0c48udm537.com/js/common.js?v=1702059537"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var gameNameDivs = document.querySelectorAll('.gameList dt');

        gameNameDivs.forEach(function (gameNameDiv) {
            gameNameDiv.addEventListener('click', function () {
                var secondDiv = this.nextElementSibling;
                if (secondDiv.style.display === 'block') {
                    secondDiv.style.display = 'none';
                } else {
                    secondDiv.style.display = 'block';
                }
            });
        });
    });
</script>

</body>
</html>