<?php

namespace App\Http\Controllers;

use App\Models\CashTransaction;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CashTransactionController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $transactions = CashTransaction::with('member')
            ->orderBy('transaction_date')
            ->orderBy('id')
            ->get();

        if ($request->expectsJson()) {
            return response()->json(['data' => $transactions]);
        }

        $income = $transactions->where('type', 'masuk')->sum('amount');
        $expense = $transactions->where('type', 'keluar')->sum('amount');
        $runningBalance = 0;

        $transactions = $transactions->map(function (CashTransaction $transaction) use (&$runningBalance) {
            $runningBalance += $transaction->type === 'masuk'
                ? $transaction->amount
                : -$transaction->amount;
            $transaction->setAttribute('running_balance', $runningBalance);

            return $transaction;
        });

        $filter = $request->query('type');
        if (in_array($filter, ['masuk', 'keluar'], true)) {
            $transactions = $transactions->where('type', $filter);
        }

        return view('bendahara.kas', [
            'transactions' => $transactions,
            'members' => User::query()
                ->whereIn('role', ['anggota', 'presbem'])
                ->orderBy('name')
                ->get(['id', 'name', 'nim']),
            'income' => $income,
            'expense' => $expense,
            'balance' => $income - $expense,
            'filter' => $filter,
        ]);
    }

    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $data = $this->validatedData($request);
        $data['created_by'] = $request->user()->id;

        $transaction = CashTransaction::create($data);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Transaksi berhasil disimpan.', 'data' => $transaction->load('member')], 201);
        }

        return redirect()->route('bendahara.kas')->with('success', 'Transaksi berhasil disimpan.');
    }

    public function update(Request $request, CashTransaction $transaction): RedirectResponse|JsonResponse
    {
        $transaction->update($this->validatedData($request));

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Transaksi berhasil diperbarui.', 'data' => $transaction->fresh()->load('member')]);
        }

        return redirect()->route('bendahara.kas')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Request $request, CashTransaction $transaction): RedirectResponse|JsonResponse
    {
        $transaction->delete();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Transaksi berhasil dihapus.']);
        }

        return redirect()->route('bendahara.kas')->with('success', 'Transaksi berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request): array
    {
        return $request->validate([
            'type' => ['required', Rule::in(['masuk', 'keluar'])],
            'transaction_date' => ['required', 'date'],
            'description' => ['required', 'string', 'max:150'],
            'amount' => ['required', 'integer', 'min:1', 'max:999999999999'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'user_id' => [
                'nullable',
                'integer',
                Rule::exists('users', 'id')->whereIn('role', ['anggota', 'presbem']),
            ],
        ]);
    }
}
