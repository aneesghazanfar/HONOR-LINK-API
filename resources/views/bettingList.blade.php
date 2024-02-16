<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Add your head content here -->
</head>

<body class="menuOpen">
    @include('header')
    @include('side-bar')

    <div class="container">
    <div class="containerWrap">
        <div class="inner">
            <h2><span class="material-icons">subtitles</span> Betting List</h2>
            <div class="total_count">Total {{ $total }}</div>
            <div class="tableWrap">
                <table class="table01">
                    <colgroup>
                        <col width="6%">
                        <col width="">
                        <col width="10%">
                        <col width="10%">
                        <col width="15%">
                        <col width="15%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Game</th>
                            <th>Betting Amount</th>
                            <th>Result Amount</th>
                            <th>created_at</th>
                            <th>processed_at</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($_GET['page']))
                                $page = $_GET['page'];
                            else
                                $page = 1;
                            $i = 0;        
                            ?>
                        @php
                            $sortedTransactions = $transactions->sortByDesc('no');
                        @endphp
                        @foreach($sortedTransactions as $transaction)
                        @if($i >= $page * 20 - 20 && $i < $page * 20)
                        @if($transaction['amount'] != 0)
                        

                            <tr class="{{ $transaction['amount'] > 0 ? 'plus' : 'minus' }}">
                            <td>{{ $total }}</td>
                                <td class="title">
                                    {{ $transaction['gametitle'] }}
                                    <span class="icoBox">{{ $transaction['gamevendor'] }}</span>
                                    <span class="icoBox">{{ $transaction['gametype'] }}</span>
                                    <span class="roundId">{{ $transaction['gameround'] }}</span>
                                </td>
                                
                                <?php
                                    $amount = App\Models\Transactions::where('no', $transaction['no'] + 1)->get();
                                    $bet_amount = $transaction['before'] - $amount[0]['before'];
                                ?>
                                <td>{{ $bet_amount }}</td>

                       
                                <td class="mtype">{{ $transaction['amount'] }}</td>
                                <td>{{ $transaction['created_at'] }}</td>
                                <td>{{ $transaction['processed_at'] }}</td>
                            </tr>
                            <?php
                              $total--;
                              ?>
                            @endif
                            <?php $i++; 
                              
                            ?>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pageWrap">
            <nav class="pg_wrap">
    <span class="pg">
        @if($page > 1)
            <a href="?page=1">First</a>
            <a href="?page={{ $page - 1 }}">Prev</a>
        @endif

        @php
            $startPage = max(1, $page - 9);
            $endPage = min($lastPage, $startPage + 9);
        @endphp

        @for ($i = $startPage; $i <= $endPage; $i++)
            @if($i == $page)
                <strong class="pg_current">{{ $i }}</strong>
            @else
                <a href="?page={{ $i }}">{{ $i }}</a>
            @endif
        @endfor

        @if($page + 9 < $lastPage)
            <a href="?page={{ $endPage + 10 }}">Next</a>
        @endif

        @if($page < $lastPage)
            <a href="?page={{ $lastPage }}">End</a>
        @endif
    </span>
</nav>




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
        // onload delay 30s
        $(onload(function () {
            setTimeout(function () {
                $('.delayLayer').fadeOut();
            }, 30000);
        }));
    </script>
</body>

</html>
