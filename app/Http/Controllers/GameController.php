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


    //
    public function gameList(Request $request)
 {
    

              $response = Http::withHeaders([
                'accept' => 'application/json',
                'Authorization' => 'Bearer TgeQK2POExchRm2FoWNHeTHjS6LlseeTDwwxjcsp',
            ])->get('https://api.honorlink.org/api/game-list');
        
            $games = $response->json(); // This will contain your response body as an array
            // grouped by vendor
            $games = collect($games)->groupBy('vendor')->toArray();

            return view('game_list', compact('games'));

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



return redirect()->away($game_link);


 }

public function bettingListpage()
{

      $current_page = 1;
      $total = Transactions::where('userid', Auth::user()->userid)->count();

      $no_of_pages = $total / 20;
      $lastPage = ceil($no_of_pages);
      $transactions = Transactions::where('userid', Auth::user()->userid)->get();

    return view('bettingList', compact('transactions',  'lastPage', 'current_page', 'total'));
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