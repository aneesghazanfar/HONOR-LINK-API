<body class="menuOpen">
    @include('header')
    @include('side-bar')
    <div class="container">
        <div class="containerWrap">
            <div class="inner">
                <h2><span class="material-icons">subtitles</span> Game List</h2>

                <ul class="gameUnit">
                @foreach ($games as $vendor => $game)
                    <?php
                    $game_count = count($game);

?>
                        <dl class="gameList" data-vd="{{ $vendor }}" data-vd="{{ $vendor }}">
                            <input type="hidden" name="vendor" value="{{ $vendor }}">
                            <dt><a href="#REAL">{{ $vendor }} <span>{{ $game_count }}</span></a></dt>
                            <dd class="secondDiv" style="display: none;">
                                <ul class="gameUnit">
                                @foreach($game as $key => $value)
                                    <li>
                                    <a target="_blank" href="{{ route('launch_game', ['id' => $value['id'], 'vender' =>  $vendor]) }}" data-vd="{{ $vendor }}">
                                            <div class="imgWrap">
                                                <img src="{{ $value['thumbnail'] }}"
                                                   onerror="errorImg($(this));">
                                            </div>
                                            <div class="title">[{{ $value['provider'] }}] {{ $value['title'] }}</div>
                                            @if($value['langs'] != null)
                                            <div class="subtitle">{{ $value['langs']['ko'] }}</div>
                                            @endif
                                            </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </dd>
                        </dl>
                    @endforeach
                </ul>
            </div>
        </div>
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
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var gameNameDivs = document.querySelectorAll('.gameList dt');

        gameNameDivs.forEach(function(gameNameDiv) {
            gameNameDiv.addEventListener('click', function() {
                var secondDiv = this.nextElementSibling;
                if (secondDiv.style.display === 'block') {
                    secondDiv.style.display = 'none';
                } else {
                    secondDiv.style.display = 'block';
                }
            });
        });
    });


    function errorImg(t){
    console.log("new");
    t.parent().prepend('<div class="noimg"></div>');
    t.remove();
}
    </script>

</body>
</html>