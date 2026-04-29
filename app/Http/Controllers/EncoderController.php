<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class EncoderController extends Controller
{
    public function finance()
    {
        return view('encoder_POV.finance');
    }

    public function store(Request $request)
    {
        $funds    = $request->fund_amount ?? 0;
        $expenses = $request->expenses_amount ?? 0;

        if ($funds > 0 && $expenses > 0) {
            $type = 'both';
        } elseif ($funds > 0) {
            $type = 'funds';
        } else {
            $type = 'expenses';
        }

        Transaction::create([
            'usersID'                => Auth::user()->usersID,
            'treasurerAddmoneyID'    => null,
            'treasurerAddexpensesID' => null,
            'type'                   => $type,
            'description'            => $request->fund_description ?? $request->expenses_description,
            'funds_amount'           => $funds,
            'expenses_amount'        => $expenses,
            'total_amount'           => $funds - $expenses,
            'date'                   => $request->date ?? now()->toDateString(),
            'notes'                  => $request->notes ?? '',
            'status'                 => 'pending',
        ]);

        return redirect()->route('encoder.transactions')
                         ->with('success', 'Entry saved! Waiting for treasurer approval.');
    }

    public function transactions()
    {
        $transactions = Transaction::with('user')
            ->where('usersID', Auth::user()->usersID)
            ->orderBy('date', 'desc')
            ->get();

        return view('encoder_POV.transaction', compact('transactions'));
    }
}