<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;


class CallbackController extends Controller
{
    //
    public function handle(Request $request)
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

}
