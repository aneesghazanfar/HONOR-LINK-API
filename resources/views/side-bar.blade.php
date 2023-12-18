
<div class="leftMenu">
    <div class="mobileMenu">
        <span class="material-icons">keyboard_arrow_left</span>
    </div>
    <ul>
    @php
        $cr = Route::current()->uri();
        // var_dump($cr)
    @endphp
        <li class="{{ $cr == '/' ? 'on' : '' }}">
            <a href="/">Home</a>
        </li>
        <li class="{{ $cr == 'res/gameList' ? 'on' : '' }}">
            <a href="/res/gameList">Game List</a>
        </li>
        <li class="{{ $cr == 'res/bettingList' ? 'on' : '' }}">
            <a href="/res/bettingList">Betting List</a>
        </li>
        <li class="{{ $cr == 'res/charge' ? 'on' : '' }}">
            <a href="/res/charge">Charge Request</a>
        </li>
        <li class="{{ $cr == 'res/exchange' ? 'on' : '' }}">
            <a href="/res/exchange">Exchange Request</a>
        </li>
    </ul>
</div>




