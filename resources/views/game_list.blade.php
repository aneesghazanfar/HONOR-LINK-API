@include('header')
@include('side-bar')

<head>
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
    </style>
</head>

<div class="container">
    <div class="content">
        <h2><span class="material-icons">subtitles</span> GAME LIST</h2>
        @foreach ($games as $game => $value)
            <div >
                <dl class="gameList" data-vd="live-inplay">
                    <dt><a href="#REAL">{{ $game }} <span>1</span></a></dt>
                    <dd>
                       
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
</body>

</html>
