<?php

namespace App\Schedules;

use Illuminate\Support\Facades\Http;
use App\Models\Transactions;
use App\Models\User;
use Carbon\Carbon;

class TransactionsUpdate
{
    public function handle()
    {

        // $start_date_time = now()->subDays(14)->format('Y-m-d H:i:s');
        // $end_date_time = now()->addHours(1)->format('Y-m-d H:i:s');
        $start_date_time = now()->subHours(1)->format('Y-m-d H:i:s');
        $end_date_time = now()->format('Y-m-d H:i:s');

        $response = Http::withHeaders([
            'accept' => 'application/json',
            'Authorization' => 'Bearer TgeQK2POExchRm2FoWNHeTHjS6LlseeTDwwxjcsp',
        ])->get('https://api.honorlink.org/api/transactions?', [
            'start' => $start_date_time,
            'end' => $end_date_time,
            'page' => 1,
            'perPage' => '1000',
        ]);

        $trans = $response->json();
        $user_name = User::find(1)->email;

        foreach ($trans as $tran) {
            foreach ($tran as $tra) {
                $api_user_name = $tra['user']['username'];

                if ($user_name == $api_user_name && $tra['details'] != null) {
                    $existingTransaction = Transactions::where('tid', $tra['id'])->first();

                    if (is_array($tra['details']) && array_key_exists('game', $tra['details']) && is_array($tra['details']['game'])) {
                        if (!$existingTransaction) {
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
                            $transaction->detail = 0; // Set to null or handle appropriately
                            $transaction->processed_at = substr($tra['processed_at'], 0, -9);
                            $transaction->detailUpdate = 0; // Set to null or handle appropriately
                            $transaction->created_at = substr($tra['created_at'], 0, -9);
                            $transaction->updated_at = substr($tra['created_at'], 0, -9);
                            $transaction->deleted_at = substr($tra['created_at'], 0, -9);

                            // Save the transaction
                            $transaction->save();
                        }
                    }
                }
            }
        }
    }
}
