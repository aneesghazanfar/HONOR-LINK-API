@include('header')
@include('side-bar')

<head>
<style>
    .container {
        margin-top: 1.5cm;
        margin-left: 210px; /* Adjust based on your sidebar width */
        padding: 20px;
        background-color: #fff;
        transition: margin-left 0.3s; /* Add smooth transition for better user experience */
    }

    .content {
        width: calc(100% - 40px); /* Adjust the width based on your design */
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
    list-style: disc; /* Added bullets for list items */
    padding: 2px 0;
    font-size: 1.2em;
    font-weight: 500;
    color: #000; /* Set text color to black for list items */
    font-family: "Spoqa Han Sans", sans-serif; /* Set font family */
}

/* Additional styles for accessibility */
.content ul.main li {
    contrast: 7.45; /* Set contrast */
}

.content ul.main li:focus {
    outline: 2px solid #555555; /* Set focus outline color */
}

    .material-icons {
      
    font-size: 1.5em;
    margin: 0 0 3px 0;
}
</style>
</head>

<div class="container">
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
