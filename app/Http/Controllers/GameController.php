<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;


class GameController extends Controller
{
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

            // foreach ($games as $vendor => $game) {
            //     // dd(($vendor));
            //     foreach($game as $key => $value) {
            //         // dd($value);
            //         // $games[$vendor][$key]['image'] = "https://thumbnails.honorlink.org/LiveInplay/" . $value['image'];
            //         dd($value);
            //     }
            // }
                // dd($games);
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


 function bettingList(Request $request)
 {
    
  // curl -X 'GET' \
  // 'https://api.honorlink.org/api/transactions?start=2023-12-03%2022%3A00%3A21&end=2023-11-19%2012%3A26%3A01&page=10&perPage=20' \
  // -H 'accept: application/json' \
  // -H 'Authorization: Bearer TgeQK2POExchRm2FoWNHeTHjS6LlseeTDwwxjcsp'

  $response = Http::withHeaders([
    'accept' => 'application/json',
    'Authorization' => 'Bearer TgeQK2POExchRm2FoWNHeTHjS6LlseeTDwwxjcsp',])
    ->get('https://api.honorlink.org/api/transactions?', [
        'start' => '2023-12-03 22:00:21',
        'end' => '2023-11-19 12:26:01',
        'page' => '1',
        'perPage' => '20',
    ]);
    $trans = $response->json(); // This will contain your response body as an array
    dd($trans);
    return view('bettingList');
 }

}
