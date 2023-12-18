<body class="menuOpen">
    @include('header')
    @include('side-bar')
        <div class="container">
            <div class="containerWrap">
                <div class="inner">
<h2><span class="material-icons">subtitles</span> Charge Request</h2>

<div class="loginWrap charge">
    <div>
    <?php
use Illuminate\Support\Facades\Http;

$response = Http::withHeaders([
    'accept' => 'application/json',
    'Authorization' => 'Bearer TgeQK2POExchRm2FoWNHeTHjS6LlseeTDwwxjcsp',
])->get('https://api.honorlink.org/api/my-info');
            $balance = $response->json()['balance'];
            // dd($response->json());
            ?>
            <div class="register">
                <div><label>Current Balance</label></div>
                <div class="input">
                    <input type="text" name="balance" id="balance" value="{{ $data['balance'] }}" readonly="" class="ed">
                    <span>KRW</span>
                </div>
            </div>
            <div class="register">
                <div><label class="req">Charge Amount</label></div>
                <div class="input">
                    <input type="text" name="amount" id="amount" placeholder="Charge Amount" required="" class="ed money" maxlength="6">
                    <input type="hidden" name="agent_amount" id="agent_amount" value="{{ $balance }}" readonly="" class="ed">
                    <span>KRW</span>
                </div>
            </div>
            <div>
            <button class="btnLogin" id="exchangeBtn">Charge Request</button>
            </div>
            <form method="POST" action="{{ route('add_charge') }}">
            @csrf
            <div class="winAlert" style="display: none;">
            <input type="hidden" name="amount" id="amount" value="" readonly="" class="ed">
            <input type="hidden" name="username" id="username" value="{{ $data['username'] }}" readonly="" class="ed">
            <div class="body">Your <strong>charge</strong> is complete.</div>
            <div class="bottom">
                <button type="submit">확인</button>
            </div>
        </div>
        </form>
    </div>
</div>

<script>
    // Get references to the button and the alert div
const exchangeBtn = document.getElementById('exchangeBtn');
const winAlert = document.querySelector('.winAlert');
// get amount value


// Add a click event listener to the Exchange Request button
exchangeBtn.addEventListener('click', function() {
    // Show the winAlert div when the button is clicked
    const amount = document.getElementById('amount').value;
    const agent_amount = document.getElementById('agent_amount').value;
    // console.log(agent_amount);
    if(amount > agent_amount){
        alert('You do not have enough balance');
        return false;
    }
    // pass amount value to winAlert input
    document.querySelector('.winAlert input').value = amount;

console.log(amount);
    winAlert.style.display = 'block';
});

// Handling the '확인' button inside the winAlert div
const confirmBtn = document.getElementById('confirmBtn');
confirmBtn.addEventListener('click', function() {
    // Hide the winAlert div when the '확인' button is clicked
    winAlert.style.display = 'none';
});

</script>

                </div>
            </div>
        </div>
        <div id="overlayer"></div>
        <div id="overlayer02"></div>
        <div class="winAlert">
            <div class="body"></div>
            <div class="bottom"></div>
        </div>
        <div class="delayLayer"><div><div></div></div></div>

        <iframe name="hiddenframe" class="hiddenframe"></iframe>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
        <script src="{{ asset('/js/common.js?v=1702823081') }}"></script>
    

</body></html>