<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
// use App\Http\Controllers\GameController;

use Illuminate\Support\Facades\Http;


use App\Models\Transactions;
use Carbon\Carbon; 

use App\Models\User;

use Illuminate\Support\Facades\Auth;




class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command(GameController::class, 'cronJob');
        // schedule for controller function 
        $schedule->call(function () {
            // dd("cron job is working fine!");
            // $new = 1;

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
//     // global $trans;
    $trans = $response->json();
    // dd($trans);
    // dd("new");
    // $user_name = Auth::user()->email;
    $user_name = User::find(1);
    $user_name = $user_name->email;

// $user_name = "anees";
    // dd($user_name);

    foreach ($trans as $tran) {
        // dd ($trans);
          foreach ($tran as $tra) {
            // dd("done");
              $api_user_name = $tra['user']['username'];
            //   dd($api_user_name);
                    if ($user_name == $api_user_name && $tra['details'] != null) {
                        // Check if the transaction with the same 'tid' already exists
                        $existingTransaction = Transactions::where('tid', $tra['id'])->first();

                        if (!$existingTransaction) {
                            // If it doesn't exist, create a new transaction and save it
                            $transaction = new Transactions();
                            // Set values for the fields
                            $transaction->userno = 1; 
                            $transaction->userid = $tra['user']['id'];
                            $transaction->tid = $tra['id'];
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
                            $transaction->save();
                        }
                    }
                }
            }

        })->everyMinute();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }

}
