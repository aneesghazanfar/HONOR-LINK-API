<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $fillable = [
        'userid', 'type', 'amount', 'before', 'status',
        'gameid', 'gametype', 'gameround', 'gametitle', 'gamevendor',
        'processed_at', 'created_at', 'updated_at',
    ];
}
