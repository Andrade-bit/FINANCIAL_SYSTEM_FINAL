<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreasurerDashboard extends Model
{
    protected $table = 'treasurer_dashboard';
    protected $primaryKey = 'treasurerDashboardID';

    public $timestamps = false;

    protected $fillable = [
        'usersID',
        'total_balance',
        'total_collections',
        'total_expenses',
    ];
}