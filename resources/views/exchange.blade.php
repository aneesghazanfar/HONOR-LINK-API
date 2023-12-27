<body class="menuOpen">
    @include('header')
    @include('side-bar')
    <div class="container">
        <div class="containerWrap">
            <div class="inner">
                <h2><span class="material-icons">subtitles</span> Exchange Request</h2>
                <div class="loginWrap charge">
                    <div>
                        <div class="register">
                            <div><label>Current Balance</label></div>
                            <div class="input">
                                <input type="text" name="balance" id="balance" value="{{ $data['balance'] }}"
                                    readonly="" class="ed">
                                <span>KRW</span>
                            </div>
                        </div>
                        <div class="register">
                            <div><label class="req">Exchange Amount</label></div>
                            <div class="input">
                                <input type="text" name="amount" id="amount" placeholder="Exchange Amount" required=""
                                    class="ed money" maxlength="6">
                                <span>KRW</span>
                            </div>
                        </div>
                        <div>
                            <button class="btnLogin" id="exchangeBtn">Exchange Request</button>
                        </div>
                        <form method="POST" action="{{ route('sub_balance') }}">
                            @csrf
                            <div class="winAlert" style="display: none;">
                                <input type="hidden" name="amount" id="amount" value="" readonly="" class="ed">
                                <input type="hidden" name="username" id="username" value="{{ $data['username'] }}"
                                    readonly="" class="ed">
                                <div class="body">Your <strong>exchange</strong> has been completed.</div>
                                <div class="bottom">
                                    <button type="submit">확인</button>
                                </div>
                            </div>
                        </form>
                    </div>
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
    <script src="https://demo.0c48udm537.com/js/common.js?v=1703002556"></script>

    <script>
                // Get references to the button and the alert div
                const exchangeBtn = document.getElementById('exchangeBtn');
                const winAlert = document.querySelector('.winAlert');
                // get amount value


                // Add a click event listener to the Exchange Request button
                exchangeBtn.addEventListener('click', function() {
                    // Show the winAlert div when the button is clicked
                    const amount = document.getElementById('amount').value;
                    const user_amount = document.getElementById('balance').value;
                    console.log(amount);
                    console.log(user_amount);
                    if (amount > user_amount) {
                        alert('You do not have enough balance.');
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
</body>

</html>