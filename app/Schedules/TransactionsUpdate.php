<?php

namespace App\Schedules;

use Illuminate\Support\Facades\Http;
use App\Models\Transactions;
use Carbon\Carbon;

class TransactionsUpdate
{
    public function handle(int $page = 1)
    {
        $start_date_time = now()->subHours(1)->format('Y-m-d H:i:s');
        $end_date_time = now()->format('Y-m-d H:i:s');
        $limit = 1000;

        $response = Http::withHeaders([
            'accept' => 'application/json',
            'Authorization' => 'Bearer TgeQK2POExchRm2FoWNHeTHjS6LlseeTDwwxjcsp',
        ])->get('https://api.honorlink.org/api/transactions?', [
            'start' => $start_date_time,
            'end' => $end_date_time,
            'page' => $page,
            'perPage' => $limit,
            'withDetails' => 1,
        ]);

        $trans = $response->json();


        $count = 0;

        if (array_key_exists('data', $trans)) {
            foreach ($trans['data'] as $tra) {
                $existingTransaction = Transactions::where('tid', $tra['id'])->first();

                $transaction = new Transactions();
                if ($existingTransaction) {
                    if (is_array($tra['external'])) {
                        if (is_array($tra['external']['detail'])) {
                            $detail = json_encode($tra['external']['detail']);

                            $transaction->where([
                                ['tid', '=', $tra['id']],
                                ['detailUpdate', '<>', 1],
                            ])->update([
                                'detail' => $detail,
                                'detailUpdate' => 1
                            ]);
                        }
                    }
                } else {
                    // Set values for the fields
                    $transaction->userno = 1;
                    $transaction->userid = $tra['user']['id'];
                    $transaction->tid = $tra['id'];
                    $transaction->type = $tra['type'];
                    $transaction->amount = $tra['amount'];
                    $transaction->before = $tra['before'];
                    $transaction->status = $tra['status'];
                    $transaction->detail = 0; // Set to null or handle appropriately
                    $transaction->processed_at = substr($tra['processed_at'], 0, -9);
                    $transaction->detailUpdate = 0; // Set to null or handle appropriately
                    $transaction->created_at = substr($tra['created_at'], 0, -9);
                    $transaction->updated_at = substr($tra['created_at'], 0, -9);
                    $transaction->deleted_at = substr($tra['created_at'], 0, -9);

                    if (is_array($tra['details'])) {
                        if (array_key_exists('game', $tra['details'])) {
                            if (array_key_exists('id', $tra['details']['game'])) {
                                $transaction->gameid = $tra['details']['game']['id'];
                            }
                            if (array_key_exists('type', $tra['details']['game'])) {
                                $transaction->gametype = $tra['details']['game']['type'];
                            }
                            if (array_key_exists('round', $tra['details']['game'])) {
                                $transaction->gameround = $tra['details']['game']['round'];
                            }
                            if (array_key_exists('title', $tra['details']['game'])) {
                                $transaction->gametitle = $tra['details']['game']['title'];
                            }
                            if (array_key_exists('vendor', $tra['details']['game'])) {
                                $transaction->gamevendor = $tra['details']['game']['vendor'];
                            }
                        }
                    }

                    // Save the transaction
                    $transaction->save();
                }
                $count++;
            }
        }

        if ($count >= $limit) {
            $page++;
            $this->handle($page);
        }
    }
}
