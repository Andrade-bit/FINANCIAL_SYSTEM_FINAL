<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table      = 'treasurer_transactions';
    protected $primaryKey = 'treasurerTransactionsID';

    protected $fillable = [
        'usersID',
        'treasurerAddmoneyID',
        'treasurerAddexpensesID',
        'type',
        'description',
        'funds_amount',
        'expenses_amount',
        'total_amount',
        'date',
        'notes',
        'status',
        'approved_by',
        'approved_at',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'usersID', 'usersID');
    }
}