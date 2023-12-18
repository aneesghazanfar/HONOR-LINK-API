@include('header')
@include('side-bar')

<div class="container">
    <div class="content">
      
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
<script src="{{ asset('/js/common.js?v=1702059537') }}"></script>
</body>

</html>