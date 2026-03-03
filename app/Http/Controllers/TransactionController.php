<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request, BankAccount $bankAccount)
    {
        return view('bank_account.transaction', compact('bankAccount'));
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'bank_account_id' => 'required',
            'amount'          => 'required|gt:0',
            'date'            => 'required',
        ]);

        $bankAccount = BankAccount::find($request->bank_account_id);

        if ($bankAccount) {
            $transaction = Transaction::create([
                'date'              => $request->date,
                'bank_account_id'   => $bankAccount->id,
                'type'              => 'deposit',
                'description'       => 'Deposit',
                'amount'            => $request->amount,
                'remarks'           => $request->remarks,
            ]);
            $bankAccount->update([
                'amount' => $bankAccount->amount + $transaction->amount
            ]);
            return redirect()->route('bank_account.transaction', $bankAccount)->withSuccess('Data saved');
        } else {
            return redirect()->route('bank_account.index')->withError('Bank account not found');
        }
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'bank_account_id' => 'required',
            'amount'          => 'required|gt:0',
            'date'            => 'required',
        ]);

        $bankAccount = BankAccount::find($request->bank_account_id);

        if ($bankAccount) {
            $transaction = Transaction::create([
                'date'              => $request->date,
                'bank_account_id'   => $bankAccount->id,
                'type'              => 'withdraw',
                'description'       => 'Withdrawal',
                'amount'            => -$request->amount,
                'remarks'           => $request->remarks,
            ]);
            $bankAccount->update([
                'amount' => $bankAccount->amount + $transaction->amount
            ]);
            return redirect()->route('bank_account.transaction', $bankAccount)->withSuccess('Data saved');
        } else {
            return redirect()->route('bank_account.index')->withError('Bank account not found');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'transaction_id'  => 'required',
            'bank_account_id' => 'required',
            'amount'          => 'required|gt:0',
            'date'            => 'required',
        ]);

        $transaction = Transaction::find($request->transaction_id);

        if ($transaction) {
            $bankAccount = $transaction->bankAccount;
            if (in_array($transaction->type, ['capital', 'deposit'])) {
                $transaction->update([
                    'date'              => $request->date,
                    'amount'            => $request->amount,
                    'remarks'           => $request->remarks,
                ]);
            } else {
                $transaction->update([
                    'date'              => $request->date,
                    'amount'            => -$request->amount,
                    'remarks'           => $request->remarks,
                ]);
            }
            $this->recalculate($bankAccount);

            return redirect()->route('bank_account.transaction', $bankAccount)->withSuccess('Data updated');
        } else {
            return redirect()->back()->withError('Transaction not found');
        }
    }

    public function destroy(Transaction $transaction)
    {
        $bankAccount = $transaction->bankAccount;
        $transaction->delete();
        $this->recalculate($bankAccount);

        return redirect()->route('bank_account.transaction', $bankAccount)->withSuccess('Data deleted');
    }

    public function recalculate(BankAccount $bankAccount)
    {
        $bankAccount->update([
            'amount' => $bankAccount->transactions()->sum('amount')
        ]);

        return redirect()->route('bank_account.transaction', $bankAccount)->withSuccess('Recalculate done');
    }
}
