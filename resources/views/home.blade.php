@include('header')
@include('side-bar')
<link rel="stylesheet" href="{{ asset('/css/style.css') }}">

<div class="container">
    <div class="inner">
    <div class="content">
        <h2><span class="material-icons">subtitles</span> Xtreem Demo</h2>
        <ul class="main">
            <li>Using XTREEM Default API</li>
            <li>Using the XTREEM Extension API</li>
            <li>Integrated wallet (seamless) approach</li>
            <li>Provides a list of games</li>
            <li>Provides betting history</li>
            <li>Provides site money charging capabilities</li>
            <li>Provides site money exchange capabilities</li>
            <li>Provides site money charging / exchange history</li>
        </ul>
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
