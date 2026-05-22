<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(): View
    {
        $transactions = Transaction::latest()->get();

        $totalIncome = (int) Transaction::where('type', 'income')->sum('amount');
        $totalExpense = (int) Transaction::where('type', 'expense')->sum('amount');
        $totalBalance = $totalIncome - $totalExpense;

        return view('transactions', compact(
            'transactions',
            'totalBalance',
            'totalIncome',
            'totalExpense',
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'description' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'integer', 'min:1'],
            'type' => ['required', 'in:income,expense'],
        ]);

        Transaction::create($validated);

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function destroy($id): RedirectResponse
    {
        Transaction::findOrFail($id)->delete();

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}
