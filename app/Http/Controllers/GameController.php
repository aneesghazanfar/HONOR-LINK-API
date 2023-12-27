<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Transactions;
use App\Models\User;
use Carbon\Carbon; 



class GameController extends Controller
{


  function cronJob(){
    dd("good to go");
  }
    //
    public function gameList(Request $request)
 {
       // $api_url = "https://api.honorlink.org/api";
       // $api_url = "https://api.honorlink.org/api";
       // dd(  Http::withHeaders([
       //       'KEY' => 'TgeQK2POExchRm2FoWNHeTHjS6LlseeTDwwxjcsp',
       //   ])->post($api_url . '/game-list')->body()
       // );


              // $response = Http::get(url: 'https://api.honorlink.org/api/game-list?vendor=evolution'), [

              // ]

              $response = Http::withHeaders([
                'accept' => 'application/json',
                'Authorization' => 'Bearer TgeQK2POExchRm2FoWNHeTHjS6LlseeTDwwxjcsp',
            ])->get('https://api.honorlink.org/api/game-list');
        
            $games = $response->json(); // This will contain your response body as an array
            // grouped by vendor
            $games = collect($games)->groupBy('vendor')->toArray();
            // dd($games);

            // foreach ($games as $vendor => $game) {
            //     // dd(($vendor));
            //     foreach($game as $key => $value) {
            //       if($value['vendor'] == 'evolution') {
            //         // dd($value);
            //         // $games[$vendor][$key]['image'] = "https://thumbnails.honorlink.org/LiveInplay/" . $value['image'];
            //         var_dump($value);
            //       }
            //     }
            // }
            //     dd($games);
            return view('game_list', compact('games'));
        // dd($games);
            // Now $games variable holds the response data, and you can use it in your application as needed.
            // For example, to access the first game's title:
            // $firstGameTitle = $games[0]['title'];
            // dd($firstGameTitle);
            //   $response = Http::withHeaders([
            //          'accept' => 'application/json',
            //          'Authorization' => 'Bearer TgeQK2POExchRm2FoWNHeTHjS6LlseeTDwwxjcsp',
            //      ])->get('https://api.honorlink.org/api/game-list', [
            //          'vendor' => 'evolution',
            //      ]);

            //      dd($response->json());
              // $response = Http::get('https://api.honorlink.org/api/game-list', [
              //        'query' => [
              //            'vendor' => 'evolution'
              //        ]
              //    ]);

                //  return response($response->json());


       // dd("ok");
        $data = $request->json()->all();
        \Log::info('Received callback:', $data);
        return response('Callback received successfully', 200);
 }


 function launch_game($id, $vender)
 {
  $user_name = Auth::user()->email;
  $game_id = $id;
  $vender = $vender;
  // dd($id, $vender);

  $response = Http::withHeaders([
    'accept' => 'application/json',
    'Authorization' => 'Bearer TgeQK2POExchRm2FoWNHeTHjS6LlseeTDwwxjcsp',
])->get('https://api.honorlink.org/api/game-launch-link', [
    'username' => $user_name,
    'game_id' => $game_id,
    'vendor' => $vender,
]);

$game_link = $response->json()['link'];

// dd($game_link);
// openlink in new tab

// return Response::make("<script>window.open('$game_link' '_blank');</script>");

return redirect()->away($game_link);


    // $data = $request->all();
    // return response('Callback received successfully', 200);
    // return response()->json($data);
 }


 public function bettingList()
 {
  // $pages = ceil($total / $perPage);

  // return redirect()->route('bettingListpage', ['current_page' => 1]);
  // sleep(30); // Delays the execution for 30 seconds
  // dd($page);
  
  // curl -X 'GET' \
  // 'https://api.honorlink.org/api/transactions?start=2023-12-03%2022%3A00%3A21&end=2023-11-19%2012%3A26%3A01&page=10&perPage=20' \
  // -H 'accept: application/json' \
  // -H 'Authorization: Bearer TgeQK2POExchRm2FoWNHeTHjS6LlseeTDwwxjcsp'
  $date_time = now()->format('Y-m-d H:i:s');
  // calculate date 16 days before today
  $start_date_time = now()->subDays(14)->format('Y-m-d H:i:s');
  // dd($start_date_time);
  $end_date_time = now()->addHours(9)->format('Y-m-d H:i:s');

  // dd(now()->addHours(9)->format('Y-m-d H:i:s'));
  // dd(now()->addHours(4)->format('Y-m-d H:i:s'));
  $response = Http::withHeaders([
    'accept' => 'application/json',
    'Authorization' => 'Bearer TgeQK2POExchRm2FoWNHeTHjS6LlseeTDwwxjcsp',])
    ->get('https://api.honorlink.org/api/transactions?', [
        'start' => $start_date_time,
        'end' => $end_date_time,
        'page' => 1,
        'perPage' => '1000',
        'order' => 'desc',
    ]);
    // global $trans;
    $trans = $response->json(); // This will contain your response body as an array
    session(['trans' => $trans]);

    // $trans = collect($trans)->groupBy('data')->toArray();
    // dd($trans);
    $total = 0;
    $user_name = Auth::user()->email;

    foreach($trans as $tran){

foreach($tran as $tra){

// dd($tra['details']);
 $api_user_name = $tra['user']['username'];
 if($user_name == $api_user_name && $tra['details'] != null)
{
  // dd( $tra['user']['id']);
  // dd($tra);
  $total = $total + 1;
}
}
// dd($total);

    }
    // $total = 35;
    session(['total' => $total]);

    $pages = round($total / 20);

    // Route::get('/res/bettingList/{page}', [GameController::class, 'bettingListpage'])->name('bettingListpage');
return redirect('/res/bettingList/1');
    // return redirect()->route('bettingListpage', ['current_page' => $current_page]);
    // return view('bettingList', compact('trans', 'user_name', 'total', 'pages', 'current_page'));
 }


//  function bettingListpage($current_page){
//   // dd($current_page);

//   $trans = session('trans');

//   $total = session('total');
//   $user_name = Auth::user()->email;
//   $pages = round($total / 20);
//   // dd($pages);

//   // dd($total);

//   foreach($trans as $tran){
//     // dd ($trans);

//     foreach($tran as $tra){
  
//       // dd($tra['details']);
//        $api_user_name = $tra['user']['username'];
//        if($user_name == $api_user_name && $tra['details'] != null)
//       {
//         // dd( $tra['user']['id']);    save it to  userid
//         // dd($tra['type']);            save it to type
//         // dd($tra['amount']);          save it to amount
//         // dd($tra['before']);           save it to  before
//         // dd($tra['status']);            save it to status
//         // dd($tra['details']['game']['id']);  save it to gameid
//         // dd($tra['details']['game']['type']);  save it to gametype
//         // dd($tra['details']['game']['round']);  save it to gameround
//         // dd($tra['details']['game']['title']);   save it to gametitle
//         // dd($tra['details']['game']['vendor']);   save it to gamevendor
//         // dd($tra['processed_at']);               save it to processed_at
//         // dd($tra['created_at']);                 save it to created_at and updated_at

//         // delted at will be null

//         // dd($tra);

        
//         foreach ($trans as $tran) {
//           foreach ($tran as $tra) {
//               // Use request method to handle incoming data
//               $request->merge([
//                   'userid' => $tra['user']['id'],
//                   'type' => $tra['type'],
//                   'amount' => $tra['amount'],
//                   'before' => $tra['before'],
//                   'status' => $tra['status'],
//                   'gameid' => $tra['details']['game']['id'],
//                   'gametype' => $tra['details']['game']['type'],
//                   'gameround' => $tra['details']['game']['round'],
//                   'gametitle' => $tra['details']['game']['title'],
//                   'gamevendor' => $tra['details']['game']['vendor'],
//                   'processed_at' => $tra['processed_at'],
//                   'created_at' => $tra['created_at'],
//                   'updated_at' => $tra['created_at'], // Assuming updated_at is the same as created_at
//               ]);
  
//               // Save the data to the Transactions model
//               Transactions::create($request->all());
//           }
//       }
//       }
//       }
//     }


// return view('bettingList', compact('trans', 'user_name', 'total', 'pages', 'current_page'));
// }
public function bettingListpage()
{
    // $trans = session('trans');
    $trans = array();
    $total = 118;
    $total = Transactions::count();

    $user_name = Auth::user();
    // dd($user_name);
    $pages = round($total / 20);
    $perPage = 20; // Adjust this as needed

    $transactions = Transactions::where('userno', 1)
    ->where('userid', Auth::user()->id)
    ->get();
    $transactions = collect(); // Initialize an empty collection
    foreach ($trans as $tran) {
      // dd ($trans);
        foreach ($tran as $tra) {
            $api_user_name = $tra['user']['username'];
            if ($user_name == $api_user_name && $tra['details'] != null) {
              $transactions->push($tra);
                
                $transaction = new Transactions();

                // Set values for the fields
                $transaction->userno = 1; 
                $transaction->userid = $tra['user']['id'];
                $transaction->tid = 2;
                $transaction->type = $tra['type'];
                $transaction->amount = $tra['amount'];
                $transaction->before = $tra['before'];
                $transaction->status = $tra['status'];
                $transaction->gameid = $tra['details']['game']['id'];
                $transaction->gametype = $tra['details']['game']['type'];
                $transaction->gameround = $tra['details']['game']['round'];
                $transaction->gametitle = $tra['details']['game']['title'];
                $transaction->gamevendor = $tra['details']['game']['vendor'];
                $transaction->detail = 3;
                $transaction->processed_at = Carbon::parse($tra['processed_at'])->toDateString();
                $transaction->detailUpdate = 4;
                $transaction->created_at = Carbon::parse($tra['created_at'])->toDateString();
                $transaction->updated_at = Carbon::parse($tra['created_at'])->toDateString();
                $transaction->deleted_at = Carbon::parse($tra['created_at'])->toDateString();

                // Save the transaction
                // $transaction->save();
            }
        }
    }
    // Paginate the collection
  //   $transactions = new LengthAwarePaginator(
  //     $transactions->forPage($current_page, $perPage),
  //     $total,
  //     $perPage,
      $current_page = 1;
      $total = Transactions::count();
      $no_of_pages = $total / 20;
      $lastPage = ceil($no_of_pages);
      
      
  // );
  $transactions = Transactions::all();
  // dd($transactions);

    return view('bettingList', compact('transactions', 'user_name', 'lastPage', 'current_page', 'total'));
}



 function get_data(Request $request)
 {
    $data = $request->all();
    // return response('Callback received successfully', 200);
    return response()->json($data);
 }

function charge()
  {


$response = Http::withHeaders([
    'accept' => 'application/json',
    'Authorization' => 'Bearer TgeQK2POExchRm2FoWNHeTHjS6LlseeTDwwxjcsp',
])->get('https://api.honorlink.org/api/user?username='.Auth::user()->email);
            $data = $response->json();

            // username
            return view('add_balance', compact('data'));
  }


  function add_charge(Request $request)
  {

    $response = Http::withHeaders([
      'accept' => 'application/json',
      'Authorization' => 'Bearer TgeQK2POExchRm2FoWNHeTHjS6LlseeTDwwxjcsp',
  ])->post('https://api.honorlink.org/api/user/add-balance', [
    'username' => Auth::user()->email,
    'amount' => $request->amount,
]);


  // $response = Http::withHeaders($headers)
  //           ->post('https://api.honorlink.org/api/user/add-balance', [
  //               'username' => $request->username,
  //               'amount' => $request->amount,
  //           ]);
            $statusCode = $response->status();
            return redirect()->route('charge');

}


function exchange()
{
$response = Http::withHeaders([
  'accept' => 'application/json',
  'Authorization' => 'Bearer TgeQK2POExchRm2FoWNHeTHjS6LlseeTDwwxjcsp',
])->get('https://api.honorlink.org/api/user?username='.Auth::user()->email);
          $data = $response->json();
          return view('exchange', compact('data'));
}


function add_exchange(Request $request)
{


  $response = Http::withHeaders([
    'accept' => 'application/json',
    'Authorization' => 'Bearer TgeQK2POExchRm2FoWNHeTHjS6LlseeTDwwxjcsp',
])->post('https://api.honorlink.org/api/user/sub-balance', [
  'username' => Auth::user()->email,
  'amount' => $request->amount,
]);

return redirect()->route('exchange');

}
}