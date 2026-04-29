<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Models\TreasurerDashboard;

class TreasurerController extends Controller
{
    public function dashboard()
    {
        $treasurerData = TreasurerDashboard::where('usersID', Auth::user()->usersID)->first();

        $pendingTransactions = Transaction::with('user')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $allApprovedTransactions = Transaction::with('user')
            ->where('status', 'approved')
            ->orderBy('date', 'desc')
            ->get();

        return view('treasurer_POV.treausrer', compact('treasurerData', 'pendingTransactions', 'allApprovedTransactions'));
    }

    public function addFundExpenses()
    {
        $transactions = Transaction::with('user')
                                   ->orderBy('date', 'desc')
                                   ->get();
        return view('treasurer_POV.add_Funds_and_expneses', compact('transactions'));
    }

    public function finance()
    {
        return view('treasurer_POV.Finance');
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

        $this->updateDashboard();

        return redirect()->route('treasurer.addfundexpenses')
                         ->with('success', 'Entry saved successfully!');
    }

    private function updateDashboard()
    {
        $totals = Transaction::where('status', 'approved')->selectRaw('
            SUM(funds_amount) as total_collections,
            SUM(expenses_amount) as total_expenses,
            SUM(total_amount) as total_balance
        ')->first();

        $usersID = Auth::user()->usersID;

        TreasurerDashboard::updateOrCreate(
            ['usersID' => $usersID],
            [
                'total_collections' => $totals->total_collections ?? 0,
                'total_expenses'    => $totals->total_expenses ?? 0,
                'total_balance'     => $totals->total_balance ?? 0,
            ]
        );
    }

    public function transactions()
    {
        $transactions = Transaction::with('user')
                                   ->orderBy('date', 'desc')
                                   ->get();
        return view('treasurer_POV.transaction', compact('transactions'));
    }

    public function reports()
    {
        $transactions = Transaction::with('user')
                                   ->where('status', 'approved')
                                   ->orderBy('date', 'desc')
                                   ->get();

        return view('treasurer_POV.reports', compact('transactions'));
    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('treasurer_POV.Finance', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $funds    = $request->fund_amount ?? 0;
        $expenses = $request->expenses_amount ?? 0;

        if ($funds > 0 && $expenses > 0) {
            $type = 'both';
        } elseif ($funds > 0) {
            $type = 'funds';
        } else {
            $type = 'expenses';
        }

        $transaction->update([
            'type'            => $type,
            'description'     => $request->fund_description ?? $request->expenses_description,
            'funds_amount'    => $funds,
            'expenses_amount' => $expenses,
            'total_amount'    => $funds - $expenses,
            'date'            => $request->date ?? now()->toDateString(),
            'notes'           => $request->notes ?? '',
        ]);

        $this->updateDashboard();

        return redirect()->route('treasurer.addfundexpenses')
                         ->with('success', 'Entry updated successfully!');
    }

    public function destroy($id)
    {
        Transaction::findOrFail($id)->delete();
        $this->updateDashboard();

        return redirect()->route('treasurer.addfundexpenses')
                         ->with('success', 'Entry deleted successfully!');
    }

    public function approve($id)
    {
        Transaction::findOrFail($id)->update([
            'status'      => 'approved',
            'approved_by' => Auth::user()->usersID,
            'approved_at' => now(),
        ]);

        $this->updateDashboard();

        return redirect()->route('treasurer')
                         ->with('success', 'Entry approved successfully!');
    }

    public function reject($id)
    {
        Transaction::findOrFail($id)->update([
            'status' => 'rejected',
        ]);

        return redirect()->route('treasurer')
                         ->with('success', 'Entry rejected successfully!');
    }
}